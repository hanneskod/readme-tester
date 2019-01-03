<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\StatusInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Default text output formatter
 */
class DefaultFormatter implements FormatterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var int The number of files tested
     */
    private $fileCount = 0;

    /**
     * @var int The number of examples
     */
    private $exampleCount = 0;

    /**
     * @var int The number of ignored examples
     */
    private $ignoredCount = 0;

    /**
     * @var int The number of assertions
     */
    private $expectationCount = 0;

    /**
     * @var int The number of failed assertions
     */
    private $failureCount = 0;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function onInvokationStart(): void
    {
        $this->output->writeln("Readme-Tester by Hannes Forsgård");
    }

    public function onBootstrap(string $filename): void
    {
        $this->output->writeln("Using bootstrap <comment>$filename</comment>");
    }

    public function onFile(string $filename): void
    {
        $this->fileCount++;
        $this->output->writeln("Testing examples in <comment>$filename</comment>");
    }

    public function onExample(ExampleInterface $example): void
    {
        $this->exampleCount++;
        $this->output->writeln("<info>@example {$example->getName()->getShortName()}</info>");
    }

    public function onIgnoredExample(ExampleInterface $example): void
    {
        $this->ignoredCount++;
        if ($this->output->isVerbose()) {
            $this->output->writeln("ignored <info>@example {$example->getName()->getShortName()}</info>");
        }
    }

    public function onExpectation(StatusInterface $status): void
    {
        $this->expectationCount++;

        if (!$status->isSuccess()) {
            $this->failureCount++;
            $this->output->writeln("\n<error>{$status->getDescription()}</error>\n");
            return;
        }

        if ($this->output->isVerbose()) {
            $this->output->writeln(" {$status->getDescription()}");
        }
    }

    public function onInvokationEnd(): void
    {
        $this->output->writeln(
            sprintf(
                "<%s>%s file%s, %s tested example%s,%s %s assertion%s, %s failure%s</%s>",
                $this->failureCount ? 'error' : 'comment',
                $this->fileCount,
                $this->fileCount == 1 ? '' : 's',
                $this->exampleCount,
                $this->exampleCount == 1 ? '' : 's',
                $this->ignoredCount ? " {$this->ignoredCount} ignored examples," : '',
                $this->expectationCount,
                $this->expectationCount == 1 ? '' : 's',
                $this->failureCount,
                $this->failureCount == 1 ? '' : 's',
                $this->failureCount ? 'error' : 'comment'
            )
        );
    }
}
