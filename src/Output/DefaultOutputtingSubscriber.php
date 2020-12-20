<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;

class DefaultOutputtingSubscriber extends AbstractOutputtingSubscriber
{
    /**
     * The number of files tested
     */
    protected int $fileCount = 0;

    /**
     * The number of examples
     */
    protected int $exampleCount = 0;

    /**
     * The number of ignored examples
     */
    protected int $ignoredCount = 0;

    /**
     * The number of skipped examples
     */
    protected int $skippedCount = 0;

    /**
     * The number of assertions
     */
    protected int $expectationCount = 0;

    /**
     * The number of failed assertions
     */
    protected int $failureCount = 0;

    /**
     * Flag if the current example is passing
     */
    protected bool $examplePassed = true;

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

    public function onDebugEvent(Event\DebugEvent $event): void
    {
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln($event->getMessage());
        }
    }

    public function onFileIncluded(Event\FileIncluded $event): void
    {
        $this->fileCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln("Reading example from <comment>{$event->getFilename()}</comment>");
        }
    }

    public function onSuiteStarted(Event\SuiteStarted $event): void
    {
        $this->getOutput()->writeln("Using suite <comment>{$event->getSuite()->getSuiteName()}</comment>");
    }

    public function onSuiteDone(Event\SuiteDone $event): void
    {
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln(
                "Done executing suite <comment>{$event->getSuite()->getSuiteName()}</comment>"
            );
        }
    }

    public function onExampleIgnored(Event\ExampleIgnored $event): void
    {
        $this->ignoredCount++;
        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->writeln(
                "<comment>{$event->getMessage()}</comment>"
            );
        }
    }

    public function onEvaluationSkipped(Event\EvaluationSkipped $event): void
    {
        $this->skippedCount++;
        $this->getOutput()->writeln(
            "<comment>{$event->getMessage()}</comment>"
        );
    }

    public function onEvaluationStarted(Event\EvaluationStarted $event): void
    {
        $this->examplePassed = true;
        $this->exampleCount++;
        $this->getOutput()->write("<info>{$event->getOutcome()->getExample()->getName()->getFullName()}</info>");
    }

    public function onTestPassed(Event\TestPassed $event): void
    {
        $this->expectationCount++;

        $msg = $this->getOutput()->isVeryVerbose()
            ? $event->getStatus()->getContent()
            : $event->getStatus()->getTruncatedContent();

        if ($this->getOutput()->isVerbose()) {
            $this->getOutput()->write("\n> $msg");
        }
    }

    public function onTestFailed(Event\TestFailed $event): void
    {
        $this->examplePassed = false;
        $this->expectationCount++;
        $this->failureCount++;

        $msg = $this->getOutput()->isVerbose()
            ? $event->getStatus()->getContent()
            : $event->getStatus()->getTruncatedContent();

        $this->getOutput()->writeln("\n<error>> $msg</error>");
    }

    public function onEvaluationDone(Event\EvaluationDone $event): void
    {
        if ($this->examplePassed) {
            $this->getOutput()->writeln(" <comment>\u{2713}</comment>");
        }
    }

    public function onInvalidInput(Event\InvalidInput $event): void
    {
        $message = $this->getOutput()->isVerbose() ? $event->getVerboseMessage() : $event->getMessage();
        $this->getOutput()->writeln("<error>$message</error>");
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
                $this->ignoredCount && $this->getOutput()->isVerbose() ? " {$this->ignoredCount} ignored," : '',
                $this->skippedCount ? " {$this->skippedCount} skipped," : '',
                $this->expectationCount,
                $this->expectationCount == 1 ? '' : 's',
                $this->failureCount,
                $this->failureCount == 1 ? '' : 's',
                $this->failureCount ? 'error' : 'comment'
            )
        );
    }
}
