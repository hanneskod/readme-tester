<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\Compiler;
use hanneskod\readmetester\Config;
use hanneskod\readmetester\DependencyInjection;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\Runner;
use hanneskod\readmetester\Utils\CodeBlock;
use Crell\Tukio\OrderedProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CliConsole
{
    use DependencyInjection\DispatcherProperty;

    private Config\ConfigManager $configManager;
    private ExampleTester $exampleTester;
    private Compiler\CompilerFactoryFactory $compilerFactoryFactory;
    private Event\Listener\ExitStatusListener $exitStatusListener;
    private Event\Listener\SubscriberFactory $subscriberFactory;
    private FilesystemInputGenerator $filesystemInputGenerator;
    private Runner\RunnerFactory $runnerFactory;
    private Runner\BootstrapFactory $bootstrapFactory;
    private OrderedProviderInterface $listenerProvider;

    public function __construct(
        Config\ConfigManager $configManager,
        ExampleTester $exampleTester,
        Compiler\CompilerFactoryFactory $compilerFactoryFactory,
        Event\Listener\ExitStatusListener $exitStatusListener,
        Event\Listener\SubscriberFactory $subscriberFactory,
        FilesystemInputGenerator $filesystemInputGenerator,
        Runner\RunnerFactory $runnerFactory,
        Runner\BootstrapFactory $bootstrapFactory,
        OrderedProviderInterface $listenerProvider
    ) {
        $this->configManager = $configManager;
        $this->exampleTester = $exampleTester;
        $this->compilerFactoryFactory = $compilerFactoryFactory;
        $this->exitStatusListener = $exitStatusListener;
        $this->subscriberFactory = $subscriberFactory;
        $this->filesystemInputGenerator = $filesystemInputGenerator;
        $this->runnerFactory = $runnerFactory;
        $this->bootstrapFactory = $bootstrapFactory;
        $this->listenerProvider = $listenerProvider;
    }

    public function configure(Command $command): void
    {
        $command
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to scan for test files'
            )
            ->addOption(
                'config',
                'c',
                InputOption::VALUE_REQUIRED,
                'Read configurations from file'
            )
            ->addOption(
                'file-extension',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'File extension to use while scanning for test files'
            )
            ->addOption(
                'ignore',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Path to ignore while scanning for test files'
            )
            ->addOption(
                'stdin',
                null,
                InputOption::VALUE_NONE,
                'Read from stdin instead of scaning the filesystem'
            )
            ->addOption(
                'output',
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (default, debug, json)'
            )
            ->addOption(
                'input',
                null,
                InputOption::VALUE_REQUIRED,
                'Set input format'
            )
            ->addOption(
                'runner',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify the example runner to use (process, eval)'
            )
            ->addOption(
                'bootstrap',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'A "bootstrap" PHP file that is included before testing'
            )
            ->addOption(
                'no-bootstrap',
                null,
                InputOption::VALUE_NONE,
                "Ignore bootstrapping"
            )
            ->addOption(
                'stop-on-failure',
                's',
                InputOption::VALUE_NONE,
                "Stop processing on first failed test"
            )
        ;
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        // Setup configuration from config file

        if ($input->getOption('config')) {
            // @phpstan-ignore-next-line
            $this->configManager->loadRepository(new Config\YamlRepository($input->getOption('config')));
        } else {
            $this->configManager->loadRepository(new Config\UserConfigRepository);
        }

        // Setup configuration from command line

        $configs = [];

        if ($input->getArgument('path')) {
            $configs['paths'] = (array)$input->getArgument('path');
        }

        if ($input->getOption('file-extension')) {
            $configs['file_extensions'] = (array)$input->getOption('file-extension');
        }

        if ($input->getOption('ignore')) {
            $configs['ignore_paths'] = (array)$input->getOption('ignore');
        }

        if ($input->getOption('bootstrap')) {
            $configs['bootstrap'] = (array)$input->getOption('bootstrap');
        }

        if ($input->getOption('output')) {
            $configs['output_format'] = (string)$input->getOption('output'); // @phpstan-ignore-line
        }

        if ($input->getOption('input')) {
            $configs['input_format'] = (string)$input->getOption('input'); // @phpstan-ignore-line
        }

        if ($input->getOption('runner')) {
            $configs['runner'] = (string)$input->getOption('runner'); // @phpstan-ignore-line
        }

        if ($input->getOption('stop-on-failure')) {
            $configs['stop_on_failure'] = '1';
        }

        $this->configManager->loadRepository(new Config\ArrayRepository($configs));

        // Setup event listeners

        $subscriberIds =
            [...$this->configManager->getConfigList('subscribers'), $this->configManager->getConfig('output_format')];

        foreach ($subscriberIds as $subscriberId) {
            $subscriber = $this->subscriberFactory->createSubscriber($subscriberId);

            if ($subscriber instanceof OutputAwareInterface) {
                $subscriber->setOutput($output);
            }

            $subscriber->registerWith($this->listenerProvider);

            $this->dispatcher->dispatch(new Event\DebugEvent("Registered subscriber: $subscriberId"));
        }

        // Start

        $this->dispatcher->dispatch(new Event\ExecutionStarted);

        foreach ($this->configManager->getLoadedRepositoryNames() as $name) {
            $this->dispatcher->dispatch(new Event\ConfigurationIncluded($name));
        }

        // Create compiler

        $compiler = $this->compilerFactoryFactory
            ->createCompilerFactory($this->configManager->getConfig('input_format'))
            ->createCompiler();

        $this->dispatcher->dispatch(
            new Event\DebugEvent("Using input format: {$this->configManager->getConfig('input_format')}")
        );

        // Create bootstrap

        $bootstrap = new CodeBlock('');

        if (!$input->getOption('no-bootstrap')) {
            $bootstrap = $this->bootstrapFactory->createFromFilenames(
                $this->configManager->getConfigList('bootstrap')
            );
        }

        // Create runner

        $runner = $this->runnerFactory->createRunner($this->configManager->getConfig('runner'));

        $runner->setBootstrap($bootstrap);

        $this->dispatcher->dispatch(new Event\DebugEvent("Using runner: {$this->configManager->getConfig('runner')}"));

        // Create inputs

        if ($input->getOption('stdin')) {
            $this->dispatcher->dispatch(new Event\DebugEvent('Reading input from stdin'));
            $inputs = [new Compiler\StdinInput];
        } else {
            $inputs = $this->filesystemInputGenerator->generateFilesystemInput(
                '.',
                $this->configManager->getConfigList('paths'),
                $this->configManager->getConfigList('file_extensions'),
                $this->configManager->getConfigList('ignore_paths')
            );
        }

        // Execute tests

        $this->exampleTester->test(
            $compiler->compile($inputs),
            $runner,
            (bool)$this->configManager->getConfig('stop_on_failure')
        );

        // Done

        $this->dispatcher->dispatch(new Event\ExecutionStopped);

        return $this->exitStatusListener->getStatusCode();
    }
}
