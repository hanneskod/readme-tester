<?php

namespace hanneskod\readmetester\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\FileInfo;

/**
 * CLI command to run test
 */
class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('test')
            ->setDescription('Test examples in readme files')
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL|InputArgument::IS_ARRAY,
                'Name of file to test',
                ['README.md']
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tester = new ReadmeTester;
        foreach ($input->getArgument('filename') as $filename) {
            $output->writeln("Testing examples in <comment>$filename</comment>");
            foreach ($tester->test(new FileInfo($filename)) as $line) {
                $output->writeln(" <error>$line</error>");
            }
        }
    }
}
