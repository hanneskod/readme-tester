<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Exception\InvalidInputException;
use hanneskod\readmetester\Utils\CodeBlock;
use Crell\Tukio\OrderedProviderInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CliConsole
{
    const CONFIG_FILES_OPTION = 'config';
    const STDIN_OPTION = 'stdin';

    public function __construct(
        private Config\ConfigManager $configManager,
        private ExampleTester $exampleTester,
        private Compiler\CompilerFactoryFactory $compilerFactoryFactory,
        private Event\ExitStatusListener $exitStatusListener,
        private FilesystemInputGenerator $filesystemInputGenerator,
        private Runner\RunnerFactory $runnerFactory,
        private Runner\BootstrapFactory $bootstrapFactory,
        private OrderedProviderInterface $listenerProvider,
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function configure(Command $command): void
    {
        $command
            ->addArgument(
                Configs::PATHS_ARGUMENT,
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to scan for test files'
            )
            ->addOption(
                self::CONFIG_FILES_OPTION,
                'c',
                InputOption::VALUE_REQUIRED,
                'Read configurations from file'
            )
            ->addOption(
                Configs::FILE_EXTENSIONS_OPTION,
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'File extension to use while scanning for test files'
            )
            ->addOption(
                Configs::IGNORE_PATHS_OPTION,
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
                Configs::OUTPUT_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (' . Configs::describe(Configs::OUTPUT_ID) . ')'
            )
            ->addOption(
                Configs::INPUT_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set input format (' . Configs::describe(Configs::INPUT_ID) . ')'
            )
            ->addOption(
                Configs::RUNNER_OPTION,
                null,
                InputOption::VALUE_REQUIRED,
                'Set example runner (' . Configs::describe(Configs::RUNNER_ID) . ')'
            )
            ->addOption(
                Configs::BOOTSTRAPS_OPTION,
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'A "bootstrap" PHP file that is included before testing'
            )
            ->addOption(
                Configs::IGNORE_BOOTSTRAP_OPTION,
                null,
                InputOption::VALUE_NONE,
                "Ignore bootstrapping"
            )
            ->addOption(
                Configs::STOP_ON_FAILURE_OPTION,
                's',
                InputOption::VALUE_NONE,
                "Stop processing on first failed test"
            )
        ;
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        // Setup configuration from config file

        if ($input->getOption(self::CONFIG_FILES_OPTION)) {
            $this->configManager->loadRepository(
                // @phpstan-ignore-next-line
                new Config\YamlRepository($input->getOption(self::CONFIG_FILES_OPTION))
            );
        } else {
            $this->configManager->loadRepository(new Config\UserConfigRepository);
        }

        // Setup configuration from command line

        $configs = [];

        if ($input->getArgument(Configs::PATHS_ARGUMENT)) {
            $configs[Configs::PATHS_CONFIG] = (array)$input->getArgument(Configs::PATHS_ARGUMENT);
        }

        if ($input->getOption(Configs::FILE_EXTENSIONS_OPTION)) {
            $configs[Configs::FILE_EXTENSIONS_CONFIG] = (array)$input->getOption(Configs::FILE_EXTENSIONS_OPTION);
        }

        if ($input->getOption(Configs::IGNORE_PATHS_OPTION)) {
            $configs[Configs::IGNORE_PATHS_CONFIG] = (array)$input->getOption(Configs::IGNORE_PATHS_OPTION);
        }

        if ($input->getOption(Configs::BOOTSTRAPS_OPTION)) {
            $configs[Configs::BOOTSTRAPS_CONFIG] = (array)$input->getOption(Configs::BOOTSTRAPS_OPTION);
        }

        if ($input->getOption(Configs::OUTPUT_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::OUTPUT_CONFIG] = (string)$input->getOption(Configs::OUTPUT_OPTION);
        }

        if ($input->getOption(Configs::INPUT_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::INPUT_CONFIG] = (string)$input->getOption(Configs::INPUT_OPTION);
        }

        if ($input->getOption(Configs::RUNNER_OPTION)) {
            // @phpstan-ignore-next-line
            $configs[Configs::RUNNER_CONFIG] = (string)$input->getOption(Configs::RUNNER_OPTION);
        }

        if ($input->getOption(Configs::STOP_ON_FAILURE_OPTION)) {
            $configs[Configs::STOP_ON_FAILURE_CONFIG] = '1';
        }

        $this->configManager->loadRepository(new Config\ArrayRepository($configs));

        // Setup event listeners

        $subscribers = [
            ...$this->configManager->getConfigList(Configs::SUBSCRIBERS_CONFIG),
            Configs::expand(Configs::OUTPUT_ID, $this->configManager->getConfig(Configs::OUTPUT_CONFIG)),
        ];

        foreach ($subscribers as $subscriber) {
            if (!class_exists($subscriber)) {
                throw new \RuntimeException("Unknown subscriber '$subscriber', class does not exist");
            }

            $this->listenerProvider->addSubscriber($subscriber, $subscriber);
        }

        // Start

        $this->dispatcher->dispatch(new Event\ExecutionStarted($output));

        foreach ($this->configManager->getLoadedRepositoryNames() as $name) {
            $this->dispatcher->dispatch(new Event\ConfigurationIncluded($name));
        }

        // Create compiler

        $compiler = $this->compilerFactoryFactory
            ->createCompilerFactory($this->configManager->getConfig(Configs::INPUT_CONFIG))
            ->createCompiler();

        $this->dispatcher->dispatch(
            new Event\DebugEvent("Using input format: {$this->configManager->getConfig(Configs::INPUT_CONFIG)}")
        );

        // Create bootstrap

        $bootstrap = new CodeBlock('');

        if (!$input->getOption(Configs::IGNORE_BOOTSTRAP_OPTION)) {
            $bootstrap = $this->bootstrapFactory->createFromFilenames(
                $this->configManager->getConfigList(Configs::BOOTSTRAPS_CONFIG)
            );
        }

        // Create runner

        $runner = $this->runnerFactory->createRunner($this->configManager->getConfig(Configs::RUNNER_CONFIG));

        $runner->setBootstrap($bootstrap);

        $this->dispatcher->dispatch(
            new Event\DebugEvent("Using runner: {$this->configManager->getConfig(Configs::RUNNER_CONFIG)}")
        );

        // Create inputs

        if ($input->getOption(self::STDIN_OPTION)) {
            $this->dispatcher->dispatch(new Event\DebugEvent('Reading input from stdin'));
            $inputs = [new Compiler\StdinInput];
        } else {
            $inputs = $this->filesystemInputGenerator->generateFilesystemInput(
                '.',
                $this->configManager->getConfigList(Configs::PATHS_CONFIG),
                $this->configManager->getConfigList(Configs::FILE_EXTENSIONS_CONFIG),
                $this->configManager->getConfigList(Configs::IGNORE_PATHS_CONFIG)
            );
        }

        // Execute tests

        try {
            $this->exampleTester->test(
                $compiler->compile($inputs),
                $runner,
                (bool)$this->configManager->getConfig(Configs::STOP_ON_FAILURE_CONFIG)
            );
        } catch (InvalidInputException $exception) {
            $this->dispatcher->dispatch(new Event\InvalidInput($exception));
        }

        // Done

        $this->dispatcher->dispatch(new Event\ExecutionStopped);

        return $this->exitStatusListener->getStatusCode();
    }
}
