<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\EngineBuilder;
use hanneskod\readmetester\Example\FilterRegexpProcessor;
use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Utils\Regexp;
use Symfony\Component\Finder\Finder;

/**
 * CLI command to run test
 */
class TestCommand extends Command
{
    /**
     * Path to default bootstrap file
     */
    const DEFAULT_BOOTSTRAP = 'vendor/autoload.php';

    protected function configure(): void
    {
        $this->setName('test')
            ->setDescription('Test examples in readme file')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to scan for test files',
                []
            )
            ->addOption(
                'file-extension',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'File extension to use while scanning for test files',
                ['md', 'mdown', 'markdown']
            )
            ->addOption(
                'ignore',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Path to ignore while scanning for test files',
                ['vendor']
            )
            ->addOption(
                'filter',
                null,
                InputOption::VALUE_REQUIRED,
                'Filter which examples to test using a regular expression'
            )
            ->addOption(
                'format',
                null,
                InputOption::VALUE_REQUIRED,
                'Set output format (default or json)',
                'default'
            )
            ->addOption(
                'runner',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify the example runner to use (process or eval)',
                'process'
            )
            ->addOption(
                'bootstrap',
                null,
                InputOption::VALUE_REQUIRED,
                'A "bootstrap" PHP file that is run before testing'
            )
            ->addOption(
                'no-auto-bootstrap',
                null,
                InputOption::VALUE_NONE,
                "Don't try to load a local composer autoloader when boostrap is not definied"
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $formatter = $input->getOption('format') == 'json'
            ? new JsonFormatter($output)
            : new DefaultFormatter($output);

        $formatter->onInvokationStart();

        $engineBuilder = new EngineBuilder;

        /** @var string */
        $filter = $input->getOption('filter');

        if ($filter) {
            $engineBuilder->setProcessor(new FilterRegexpProcessor(new Regexp($filter)));
        }

        if ($bootstrap = $this->readBootstrap($input)) {
            $formatter->onBootstrap($bootstrap);
        }

        switch ($input->getOption('runner')) {
            case 'process':
                $engineBuilder->setRunner(new ProcessRunner($bootstrap));
                break;
            case 'eval':
                $engineBuilder->setRunner(new EvalRunner($bootstrap));
                break;
            default:
                /** @var string */
                $runner = $input->getOption('runner');
                throw new \RuntimeException("Unknown runner '$runner'");
        }

        $engine = $engineBuilder->buildEngine();

        $engine->registerListener($formatter);

        $exitStatus = new ExitStatusListener;
        $engine->registerListener($exitStatus);

        // TODO let finder be constructed through a DIC for better ini-setting support..
        $finder = (new Finder)->files()->in('.')->ignoreUnreadableDirs();

        // Set paths to scan
        $finder->path(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                (array)$input->getArgument('path')
            )
        );

        // Set file extensions (case insensitive)
        $finder->name(
            array_map(
                fn($extension) => '/\\.' . preg_quote($extension, '/') . '$/i',
                (array)$input->getOption('file-extension')
            )
        );

        // Set paths to ignore
        $finder->notPath(
            array_map(
                fn($path) => '/^' . preg_quote($path, '/') . '/',
                (array)$input->getOption('ignore')
            )
        );

        foreach ($finder as $file) {
            $formatter->onFile($file->getRelativePathname());
            $engine->testFile($file->getContents());
        }

        $formatter->onInvokationEnd();

        return $exitStatus->getStatusCode();
    }

    private function readBootstrap(InputInterface $input): string
    {
        /** @var string */
        $filename = $input->getOption('bootstrap');

        if ($filename) {
            if (!is_file($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to bootstrap $filename");
            }

            return (string)realpath($filename);
        }

        if (!$input->getOption('no-auto-bootstrap') && is_readable(self::DEFAULT_BOOTSTRAP)) {
            return (string)realpath(self::DEFAULT_BOOTSTRAP);
        }

        return '';
    }
}
