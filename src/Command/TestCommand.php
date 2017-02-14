<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\SourceFileIterator;

/**
 * CLI command to run test
 */
class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test')
            ->setDescription('Test examples in readme file')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more files or directories to test',
                ['README.md']
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
        $this->bootstrap($input, $output);

        $tester = new ReadmeTester;
        $exitStatus = 0;

        foreach ($input->getArgument('filename') as $source) {
            foreach (new SourceFileIterator($source) as $filename => $contents) {
                $output->writeln("Testing examples in <comment>$filename</comment>");

                foreach ($tester->test($contents) as $example => $returnObj) {
                    if ($returnObj->isSuccess()) {
                        $output->writeln(" <info>Example $example: {$returnObj->getMessage()}</info>");
                        continue;
                    }
                    $output->writeln(" <error>Example $example: {$returnObj->getMessage()}</error>");
                    $exitStatus = 1;
                }
            }
        }

        return $exitStatus;
    }

    private function bootstrap(InputInterface $input, OutputInterface $output)
    {
        if ($filename = $input->getOption('bootstrap')) {
            if (!file_exists($filename) || !is_readable($filename)) {
                throw new \RuntimeException("Unable to bootstrap $filename");
            }

            if ($output->isVerbose()) {
                $output->writeln("Loading bootstrap <comment>$filename</comment>");
            }

            return require_once $filename;
        }

        if (!$input->getOption('no-auto-bootstrap') && is_readable('vendor/autoload.php')) {
            if ($output->isVerbose()) {
                $output->writeln("Loading bootstrap <comment>vendor/autoload.php</comment>");
            }

            return require_once 'vendor/autoload.php';
        }
    }
}
