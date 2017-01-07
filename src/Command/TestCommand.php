<?php

namespace hanneskod\readmetester\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\ReadmeTester;

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
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'Name of file to test',
                ['README.md']
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tester = new ReadmeTester;
        $exitStatus = 0;

        foreach ($input->getArgument('filename') as $filename) {
            if (!is_file($filename) || !is_readable($filename)) {
                throw new \Exception("Not able to read $filename");
            }

            $output->writeln("Testing examples in <comment>$filename</comment>");

            foreach ($tester->test(file_get_contents($filename)) as $example => $returnObj) {
                if ($returnObj->isSuccess()) {
                    $output->writeln(" <info>Example $example: {$returnObj->getMessage()}</info>");
                    continue;
                }
                $output->writeln(" <error>Example $example: {$returnObj->getMessage()}</error>");
                $exitStatus = 1;
            }
        }

        return $exitStatus;
    }
}
