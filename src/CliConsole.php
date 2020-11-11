<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Config\ArrayRepository;
use hanneskod\readmetester\Config\ConfigManager;
use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Formatter\JsonFormatter;
use hanneskod\readmetester\Formatter\DefaultFormatter;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Runner\ProcessRunner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

final class CliConsole
{
    private ConfigManager $configManager;

    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
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
                'format',
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (default or json)'
            )
            ->addOption(
                'runner',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify the example runner to use (process or eval)'
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

        if ($input->getOption('format')) {
            $configs['format'] = (string)$input->getOption('format'); // @phpstan-ignore-line
        }

        if ($input->getOption('runner')) {
            $configs['runner'] = (string)$input->getOption('runner'); // @phpstan-ignore-line
        }

        if ($input->getOption('stop-on-failure')) {
            $configs['stop_on_failure'] = '1';
        }

        $this->configManager->loadRepository(new ArrayRepository($configs));

        // TODO grab all objects from DIC
        // men!
        // ConfigManager är inte redo förrän efter att allt skrivits till config här..
        // FormatterFactory??
        // RunnerFactory??
        // ExampleTesterFactory?? Denna sista känns specifikt dåligt..
            // ExampleTester::setRunner()
            // ExampleTester::setStopOnFailure()

        // JAPP, det blir bra!

        $formatter = $this->configManager->getConfig('format') == 'json'
            ? new JsonFormatter($output)
            : new DefaultFormatter($output);

        $formatter->onInvokationStart();

        $bootstrap = $this->createBootstrap($input);

        /** @var RunnerInterface */
        $runner = null;

        switch ($this->configManager->getConfig('runner')) {
            case 'process':
                $runner = new ProcessRunner($bootstrap);
                break;
            case 'eval':
                $runner = new EvalRunner($bootstrap);
                break;
            default:
                /** @var string */
                throw new \RuntimeException("Unknown runner '{$this->configManager->getConfig('runner')}'");
        }

        $tester = new ExampleTester(
            $runner,
            new ExpectationEvaluator,
            (bool)$this->configManager->getConfig('stop_on_failure')
        );

        $tester->registerListener($formatter);

        $exitStatus = new ExitStatusListener;

        $tester->registerListener($exitStatus);

        $inputs = [];

        if ($input->getOption('stdin')) {
            $inputs[] = new \hanneskod\readmetester\Compiler\StdinInput;
        } else {
            $finder = (new Finder)->files()->in('.')->ignoreUnreadableDirs();

            // Set paths to scan
            $finder->path(
                array_map(
                    fn($path) => '/^' . preg_quote($path, '/') . '/',
                    $this->configManager->getConfigList('paths')
                )
            );

            // Set file extensions (case insensitive)
            $finder->name(
                array_map(
                    fn($extension) => '/\\.' . preg_quote($extension, '/') . '$/i',
                    $this->configManager->getConfigList('file_extensions')
                )
            );

            // Set paths to ignore
            $finder->notPath(
                array_map(
                    fn($path) => '/^' . preg_quote($path, '/') . '/',
                    $this->configManager->getConfigList('ignore_paths')
                )
            );

            foreach ($finder as $file) {
                $formatter->onFile($file->getRelativePathname());
                $inputs[] = new \hanneskod\readmetester\Compiler\FileInput($file);
            }
        }

        // TODO att det är Markdown ska väll också vara en config??
        // CompilerFactoryFactory ??
        $compiler = (new \hanneskod\readmetester\Markdown\CompilerFactory)->createCompiler();

        $tester->test($compiler->compile($inputs));

        $formatter->onInvokationEnd();

        return $exitStatus->getStatusCode();
    }

    private function createBootstrap(InputInterface $input): string
    {
        // TODO Runner/BootstrapFactory::createFromFilenames() ??

        if ($input->getOption('no-bootstrap')) {
            return '';
        }

        $bootstrap = '';

        foreach ($this->configManager->getConfigList('bootstrap') as $filename) {
            if (!is_file($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to load bootstrap '$filename'");
            }

            // TODO dispatch a log event that bootstrap is used..

            $bootstrap .= "require_once '" . (string)realpath($filename) . "';\n";
        }

        return $bootstrap;
    }
}
