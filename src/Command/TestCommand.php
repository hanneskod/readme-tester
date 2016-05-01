<?php

namespace hanneskod\readmetester\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester;
use SplFileObject;

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
            )
            ->addOption(
               'format',
               'f',
               InputOption::VALUE_REQUIRED,
               'Force input file format'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tester = new readmetester\ReadmeTester;
        $exitStatus = 0;

        foreach ($input->getArgument('filename') as $filename) {
            $file = new SplFileObject($filename);
            $output->writeln("Testing examples in <comment>{$file->getRealPath()}</comment>");

            $format = $this->createFormat($input, $file);
            $output->writeln("Using format <comment>{$format->getName()}</comment>");

            foreach ($tester->test($file, $format) as $example => $returnObj) {
                if ($returnObj->isSuccess()) {
                    $output->writeln(" <info>Example $example: {$returnObj->getMessage()} </info>");
                    continue;
                }
                $output->writeln(" <error>Example $example: {$returnObj->getMessage()} </error>");
                $exitStatus = 1;
            }
        }

        return $exitStatus;
    }

    /**
     * Create file format object
     *
     * @param  InputInterface $input
     * @param  SplFileObject  $file
     * @return Format\FormatInterface
     */
    private function createFormat(InputInterface $input, SplFileObject $file)
    {
        $formatIdentifier = $input->getOption('format');

        if (!$formatIdentifier) {
            $formatIdentifier = $file->getExtension();
        }

        $formatFactory = new readmetester\Format\FormatFactory;

        return $formatFactory->createFormat($formatIdentifier);
    }
}
