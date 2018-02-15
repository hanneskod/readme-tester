<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\EngineFactory;
use hanneskod\readmetester\SourceFileIterator;
use hanneskod\readmetester\Example\RegexpFilter;
use hanneskod\readmetester\Example\UnnamedFilter;
use hanneskod\readmetester\Example\NullFilter;

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
                "One of 'std' or 'json'"
            )
            ->addOption(
                'named-only',
                null,
                InputOption::VALUE_NONE,
                'Test only named examples'
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
        $filter = $input->getOption('filter')
            ? new RegexpFilter($input->getOption('filter'))
            : ($input->getOption('named-only') ? new UnnamedFilter : new NullFilter);

        $engine = (new EngineFactory)->createEngine($filter);

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
