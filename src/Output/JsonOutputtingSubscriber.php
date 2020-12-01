<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;

final class JsonOutputtingSubscriber extends AbstractOutputtingSubscriber
{
    /**
     * @var array<string, mixed>
     */
    private $data;

    public function onExecutionStarted(Event\ExecutionStarted $event): void
    {
        $this->setOutput($event->getOutput());

        $this->data = [
            'bootstraps' => [],
            'files' => [],
            'errors' => [],
            'tests' => [],
            'counts' => [
                'files' => 0,
                'errors' => 0,
                'examples' => 0,
                'ignored' => 0,
                'skipped' => 0,
                'assertions' => 0,
                'failures' => 0,
            ]
        ];
    }

    public function onBootstrapIncluded(Event\BootstrapIncluded $event): void
    {
        $this->data['bootstraps'][] = $event->getFilename();
    }

    public function onFileIncluded(Event\FileIncluded $event): void
    {
        $this->data['files'][] = $event->getFilename();
    }

    public function onExampleIgnored(Event\ExampleIgnored $event): void
    {
        $name = $event->getExample()->getName();
        $this->data['tests'][$name->getNamespaceName()][$name->getShortName()] = 'IGNORED';
        $this->data['counts']['ignored']++;
    }

    public function onExampleSkipped(Event\ExampleSkipped $event): void
    {
        $name = $event->getExample()->getName();
        $this->data['tests'][$name->getNamespaceName()][$name->getShortName()] = 'SKIPPED';
        $this->data['counts']['skipped']++;
    }

    public function onExampleEntered(Event\ExampleEntered $event): void
    {
        $name = $event->getExample()->getName();
        $this->data['tests'][$name->getNamespaceName()][$name->getShortName()] = [];
        $this->data['counts']['examples']++;
    }

    public function onTestPassed(Event\TestPassed $event): void
    {
        $name = $event->getExample()->getName();

        $this->data['tests'][$name->getNamespaceName()][$name->getShortName()][] = [
            'success' => $event->getStatus()->getDescription()
        ];

        $this->data['counts']['assertions']++;
    }

    public function onTestFailed(Event\TestFailed $event): void
    {
        $name = $event->getExample()->getName();

        $this->data['tests'][$name->getNamespaceName()][$name->getShortName()][] = [
            'failure' => $event->getStatus()->getDescription()
        ];

        $this->data['counts']['assertions']++;
        $this->data['counts']['failures']++;
    }

    public function onInvalidInput(Event\InvalidInput $event): void
    {
        $this->data['errors'][] = $event->getMessage();
        $this->data['counts']['errors']++;
    }

    public function onExecutionStopped(Event\ExecutionStopped $event): void
    {
        $this->data['counts']['files'] = count($this->data['files']);
        $this->getOutput()->writeln((string)json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
