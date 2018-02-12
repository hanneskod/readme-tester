<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\SourceFileIterator;
use hanneskod\readmetester\Expectation\Regexp;

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
        if ($output->isVeryVerbose()) {
            $presenter = new VeryVerbosePresenter($output);
        } elseif ($output->isVerbose()) {
            $presenter = new VerbosePresenter($output);
        } else {
            $presenter = new Presenter($output);
        }

        $presenter->begin();
        $this->bootstrap($input, $presenter);

        $tester = new ReadmeTester;
        $filter = $input->getOption('filter') ? new Regexp($input->getOption('filter')) : null;

        foreach ($input->getArgument('source') as $source) {
            foreach (new SourceFileIterator($source) as $filename => $contents) {
                $presenter->beginFile($filename);

                foreach ($tester->test($contents) as $exampleName => $status) {
                    if ($filter && !$filter->isMatch($exampleName)) {
                        continue;
                    }

                    $presenter->beginAssertion($exampleName, $status);
                }
            }
        }

        $presenter->end();
        return (int)$presenter->hasFailures();
    }

    private function bootstrap(InputInterface $input, Presenter $presenter)
    {
        if ($filename = $input->getOption('bootstrap')) {
            if (!file_exists($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to bootstrap $filename");
            }

            require_once $filename;
            $presenter->bootstrap($filename);
            return;
        }

        if (!$input->getOption('no-auto-bootstrap') && is_readable(self::DEFAULT_BOOTSTRAP)) {
            require_once self::DEFAULT_BOOTSTRAP;
            $presenter->bootstrap(self::DEFAULT_BOOTSTRAP);
        }
    }
}
