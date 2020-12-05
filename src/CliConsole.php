<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Exception\InvalidInputException;
use Crell\Tukio\OrderedProviderInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CliConsole
{
    const CONFIG_FILE_OPTION = 'config';
    const STDIN_OPTION = 'stdin';
    const SUITE_OPTION = 'suite';
    const PATHS_ARGUMENT = 'path';
    const INPUT_LANGUAGE_OPTION = 'input';
    const OUTPUT_OPTION = 'output';
    const RUNNER_OPTION = 'runner';
    const FILE_EXTENSIONS_OPTION = 'file-extension';
    const IGNORE_PATHS_OPTION = 'exclude';
    const BOOTSTRAP_OPTION = 'bootstrap';
    const IGNORE_BOOTSTRAP_OPTION = 'no-bootstrap';
    const STOP_ON_FAILURE_OPTION = 'stop-on-failure';

    public function __construct(
        private Config\ConfigManager $configManager,
        private ExampleTester $exampleTester,
        private Compiler\CompilerFactoryFactory $compilerFactoryFactory,
        private Compiler\CompilerPassContainer $compilerPasses,
        private Event\ExitStatusListener $exitStatusListener,
        private FilesystemInputGenerator $filesystemInputGenerator,
        private Runner\RunnerFactory $runnerFactory,
        private OrderedProviderInterface $listenerProvider,
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function configure(Command $command): void
    {
        $command
            ->addArgument(
                self::PATHS_ARGUMENT,
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to scan for test files'
            )
            ->addOption(
                self::CONFIG_FILE_OPTION,
                'c',
                InputOption::VALUE_REQUIRED,
                'Read configurations from file'
            )
            ->addOption(
                self::SUITE_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Execute named suite'
            )
            ->addOption(
                self::FILE_EXTENSIONS_OPTION,
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'File extension to use while scanning for test files'
            )
            ->addOption(
                self::IGNORE_PATHS_OPTION,
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Path to ignore while scanning for test files'
            )
            ->addOption(
                self::STDIN_OPTION,
                null,
                InputOption::VALUE_NONE,
                'Read from stdin instead of scaning the filesystem'
            )
            ->addOption(
                self::OUTPUT_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (' . Configs::describe(Configs::OUTPUT_ID) . ')'
            )
            ->addOption(
                self::INPUT_LANGUAGE_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set input format (' . Configs::describe(Configs::INPUT_ID) . ')'
            )
            ->addOption(
                self::RUNNER_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set example runner (' . Configs::describe(Configs::RUNNER_ID) . ')'
            )
            ->addOption(
                self::BOOTSTRAP_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'A "bootstrap" PHP file that is included before testing'
            )
            ->addOption(
                self::IGNORE_BOOTSTRAP_OPTION,
                null,
                InputOption::VALUE_NONE,
                "Ignore bootstrapping"
            )
            ->addOption(
                self::STOP_ON_FAILURE_OPTION,
                's',
                InputOption::VALUE_NONE,
                "Stop processing on first failed test"
            )
        ;
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        // Setup configuration from config file

        if ($input->getOption(self::CONFIG_FILE_OPTION)) {
            $this->configManager->loadRepository(
                // @phpstan-ignore-next-line
                new Config\YamlRepository((string)$input->getOption(self::CONFIG_FILE_OPTION))
            );
        } else {
            $this->configManager->loadRepository(new Config\UserConfigRepository);
        }

        // Setup configuration from command line

        $configs = [];

        if ($input->getArgument(self::PATHS_ARGUMENT)) {
            $configs[Configs::INCLUDE_PATHS] = (array)$input->getArgument(self::PATHS_ARGUMENT);
        }

        if ($input->getOption(self::FILE_EXTENSIONS_OPTION)) {
            $configs[Configs::FILE_EXTENSIONS] = (array)$input->getOption(self::FILE_EXTENSIONS_OPTION);
        }

        if ($input->getOption(self::IGNORE_PATHS_OPTION)) {
            $configs[Configs::EXCLUDE_PATHS] = (array)$input->getOption(self::IGNORE_PATHS_OPTION);
        }

        if ($input->getOption(self::BOOTSTRAP_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::BOOTSTRAP] = (string)$input->getOption(self::BOOTSTRAP_OPTION);
        }

        if ($input->getOption(self::OUTPUT_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::OUTPUT] = (string)$input->getOption(self::OUTPUT_OPTION);
        }

        if ($input->getOption(self::INPUT_LANGUAGE_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::INPUT_LANGUAGE] = (string)$input->getOption(self::INPUT_LANGUAGE_OPTION);
        }

        if ($input->getOption(self::RUNNER_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::RUNNER] = (string)$input->getOption(self::RUNNER_OPTION);
        }

        if ($input->getOption(self::STOP_ON_FAILURE_OPTION)) {
            $configs[Configs::STOP_ON_FAILURE] = '1';
        }

        $this->configManager->loadRepository(
            new Config\ArrayRepository([Configs::CLI => $configs])
        );

        // Create bootstrap

        $bootstrap = '';

        if (!$input->getOption(self::IGNORE_BOOTSTRAP_OPTION)) {
            $bootstrap = $this->configManager->getBootstrap();

            if ($bootstrap) {
                require_once $bootstrap;
            }
        }

        // Setup event subscribers

        foreach ($this->configManager->getSubscribers() as $subscriber) {
            if (!class_exists($subscriber)) {
                throw new \RuntimeException("Unknown subscriber '$subscriber', class does not exist");
            }

            $this->listenerProvider->addSubscriber($subscriber, $subscriber);
        }

        // Dispatch events (after subscribers have been loaded)

        $this->dispatcher->dispatch(new Event\ExecutionStarted($output));

        if ($bootstrap) {
            $this->dispatcher->dispatch(new Event\BootstrapIncluded($bootstrap));
        }

        foreach ($this->configManager->getLoadedRepositoryNames() as $name) {
            $this->dispatcher->dispatch(new Event\ConfigurationIncluded($name));
        }

        // Execute suites

        if ($input->getOption(self::SUITE_OPTION)) {
            $this->executeSuite(
                // @phpstan-ignore-next-line
                $this->configManager->getSuite((string)$input->getOption(self::SUITE_OPTION)),
                $bootstrap,
                (bool)$input->getOption(self::STDIN_OPTION)
            );
        } else {
            foreach ($this->configManager->getAllSuites() as $suite) {
                $this->executeSuite($suite, $bootstrap, (bool)$input->getOption(self::STDIN_OPTION));
            }
        }

        // Done

        $this->dispatcher->dispatch(new Event\ExecutionStopped);

        return $this->exitStatusListener->getStatusCode();
    }

    private function executeSuite(Config\Suite $suite, string $bootstrap, bool $readFromStdin): void
    {
        $this->dispatcher->dispatch(new Event\SuiteStarted($suite));

        // Create compiler

        $compiler = $this->compilerFactoryFactory
            ->createCompilerFactory($suite->getInputLanguage())
            ->createCompiler($this->compilerPasses->getCompilerPasses());

        $this->dispatcher->dispatch(
            new Event\DebugEvent("Using input format: {$suite->getInputLanguage()}")
        );

        // Create runner

        $runner = $this->runnerFactory->createRunner($suite->getRunner());

        $runner->setBootstrap($bootstrap);

        $this->dispatcher->dispatch(
            new Event\DebugEvent("Using runner: {$suite->getRunner()}")
        );

        // Create inputs

        if ($readFromStdin) {
            $this->dispatcher->dispatch(new Event\DebugEvent('Reading input from stdin'));
            $inputs = [new Compiler\StdinInput];
        } else {
            $inputs = $this->filesystemInputGenerator->generateFilesystemInput(
                '.',
                $suite->getIncludePaths(),
                $suite->getFileExtensions(),
                $suite->getExcludePaths()
            );
        }

        // Execute tests

        try {
            $this->exampleTester->test(
                $compiler->compile($inputs),
                $runner,
                $suite->stopOnFailure()
            );
        } catch (InvalidInputException $exception) {
            $this->dispatcher->dispatch(new Event\InvalidInput($exception));
        }

        $this->dispatcher->dispatch(new Event\SuiteDone($suite));
    }
}
