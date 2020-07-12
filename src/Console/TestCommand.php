<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\EngineBuilder;
use hanneskod\readmetester\SourceFileIterator;
use hanneskod\readmetester\Example\FilterRegexpProcessor;
use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Utils\Regexp;

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
                'source',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more files or directories to test',
                ['README.md']
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
                'ignore-unknown-annotations',
                null,
                InputOption::VALUE_NONE,
                'Ignore example annotations that are not known to readme-tester'
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

        if ($input->getOption('ignore-unknown-annotations')) {
            $engineBuilder->setIgnoreUnknownAnnotations();
        }

        $engine = $engineBuilder->buildEngine();

        $engine->registerListener($formatter);

        $exitStatus = new ExitStatusListener;
        $engine->registerListener($exitStatus);

        /** @var array<string> */
        $sources = $input->getArgument('source');

        foreach ($sources as $source) {
            foreach (new SourceFileIterator($source) as $filename => $contents) {
                $formatter->onFile($filename);
                $engine->testFile($contents);
            }
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
