<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;

final class DefaultOutputtingSubscriber extends AbstractOutputtingSubscriber
{
    /**
     * The number of files tested
     */
    private int $fileCount = 0;

    /**
     * The number of examples
     */
    private int $exampleCount = 0;

    /**
     * The number of ignored examples
     */
    private int $ignoredCount = 0;

    /**
     * The number of skipped examples
     */
    private int $skippedCount = 0;

    /**
     * The number of assertions
     */
    private int $expectationCount = 0;

    /**
     * The number of failed assertions
     */
    private int $failureCount = 0;

    /**
     * Flag if the current example is passing
     */
    private bool $examplePassed = true;

    public function onExecutionStarted(Event\ExecutionStarted $event): void
    {
        $this->setOutput($event->getOutput());
        $this->getOutput()->writeln("Readme-Tester by Hannes Forsgård");
    }

    public function onBootstrapIncluded(Event\BootstrapIncluded $event): void
    {
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln("Using bootstrap <comment>{$event->getFilename()}</comment>");
        }
    }

    public function onConfigurationIncluded(Event\ConfigurationIncluded $event): void
    {
        $this->getOutput()->writeln("Reading configuration from <comment>{$event->getFilename()}</comment>");
    }

    public function onFileIncluded(Event\FileIncluded $event): void
    {
        $this->fileCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln("Reading example from <comment>{$event->getFilename()}</comment>");
        }
    }

    public function onExampleIgnored(Event\ExampleIgnored $event): void
    {
        $this->ignoredCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln(
                "<comment>Ignored</comment> <info>{$event->getExample()->getName()->getFullName()}</info>"
            );
        }
    }

    public function onExampleSkipped(Event\ExampleSkipped $event): void
    {
        $this->skippedCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln(
                "<comment>Skipped</comment> <info>{$event->getExample()->getName()->getFullName()}</info>"
            );
        }
    }

    public function onExampleEntered(Event\ExampleEntered $event): void
    {
        $this->examplePassed = true;
        $this->exampleCount++;
        $this->getOutput()->write("<info>{$event->getExample()->getName()->getFullName()}</info>");
    }

    public function onTestPassed(Event\TestPassed $event): void
    {
        $this->expectationCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->write("\n> {$event->getStatus()->getDescription()}");
        }
    }

    public function onTestFailed(Event\TestFailed $event): void
    {
        $this->examplePassed = false;
        $this->expectationCount++;
        $this->failureCount++;
        $this->getOutput()->writeln("\n<error>> {$event->getStatus()->getDescription()}</error>");
    }

    public function onExampleExited(Event\ExampleExited $event): void
    {
        if ($this->examplePassed) {
            $this->getOutput()->writeln(" <comment>\u{2713}</comment>");
        }
    }

    public function onExecutionStopped(Event\ExecutionStopped $event): void
    {
        $this->getOutput()->writeln(
            sprintf(
                "<%s>%s file%s, %s tested example%s,%s%s %s assertion%s, %s failure%s</%s>",
                $this->failureCount ? 'error' : 'comment',
                $this->fileCount,
                $this->fileCount == 1 ? '' : 's',
                $this->exampleCount,
                $this->exampleCount == 1 ? '' : 's',
                $this->ignoredCount ? " {$this->ignoredCount} ignored examples," : '',
                $this->skippedCount ? " {$this->skippedCount} skipped examples," : '',
                $this->expectationCount,
                $this->expectationCount == 1 ? '' : 's',
                $this->failureCount,
                $this->failureCount == 1 ? '' : 's',
                $this->failureCount ? 'error' : 'comment'
            )
        );
    }
}
