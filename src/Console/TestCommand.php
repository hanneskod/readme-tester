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
use hanneskod\readmetester\Example\RegexpFilter;
use hanneskod\readmetester\Example\UnnamedFilter;
use hanneskod\readmetester\Runner\ProcessRunner;

/**
 * CLI command to run test
 */
class TestCommand extends Command
{
    /**
     * Path to default bootstrap file
     */
    const DEFAULT_BOOTSTRAP = 'vendor/autoload.php';

    protected function configure()
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
                'flagged-only',
                null,
                InputOption::VALUE_NONE,
                'Test only examples flagged with the @example annotation'
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
                'eval'
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
        $engineBuilder = new EngineBuilder;

        if ($filter = $input->getOption('filter')) {
            $engineBuilder->setFilter(new RegexpFilter($filter));
        } elseif ($input->getOption('flagged-only')) {
            $engineBuilder->setFilter(new UnnamedFilter);
        }

        if ($input->getOption('runner') == 'process') {
            $engineBuilder->setRunner(new ProcessRunner);
        }

        if ($input->getOption('ignore-unknown-annotations')) {
            $engineBuilder->setIgnoreUnknownAnnotations();
        }

        $engine = $engineBuilder->buildEngine();

        $exitStatus = new ExitStatusListener;
        $engine->registerListener($exitStatus);

        $formatter = $input->getOption('format') == 'json'
            ? new JsonFormatter($output)
            : new DefaultFormatter($output);

        $engine->registerListener($formatter);

        $formatter->onInvokationStart();

        $this->bootstrap($input, $formatter);

        foreach ($input->getArgument('source') as $source) {
            foreach (new SourceFileIterator($source) as $filename => $contents) {
                $formatter->onFile($filename);
                $engine->testFile($contents);
            }
        }

        $formatter->onInvokationEnd();

        return $exitStatus->getStatusCode();
    }

    private function bootstrap(InputInterface $input, $formatter)
    {
        if ($filename = $input->getOption('bootstrap')) {
            if (!file_exists($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to bootstrap $filename");
            }

            require_once $filename;
            $formatter->onBootstrap($filename);
            return;
        }

        if (!$input->getOption('no-auto-bootstrap') && is_readable(self::DEFAULT_BOOTSTRAP)) {
            require_once self::DEFAULT_BOOTSTRAP;
            $formatter->onBootstrap(self::DEFAULT_BOOTSTRAP);
        }
    }
}
