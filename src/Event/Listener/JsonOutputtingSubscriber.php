<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event\Listener;

use hanneskod\readmetester\Event;
use hanneskod\readmetester\Console;
use Crell\Tukio\OrderedProviderInterface;

final class JsonOutputtingSubscriber implements SubscriberInterface, Console\OutputAwareInterface
{
    use Console\OutputAwareTrait;

    /**
     * @var array<string, mixed>
     */
    private $data;

    public function registerWith(OrderedProviderInterface $listenerProvider): void
    {
        $listenerProvider->addListener([$this, 'onExecutionStarted']);
        $listenerProvider->addListener([$this, 'onBootstrapIncluded']);
        $listenerProvider->addListener([$this, 'onFileIncluded']);
        $listenerProvider->addListener([$this, 'onExampleIgnored']);
        $listenerProvider->addListener([$this, 'onExampleSkipped']);
        $listenerProvider->addListener([$this, 'onExampleEntered']);
        $listenerProvider->addListener([$this, 'onTestPassed']);
        $listenerProvider->addListener([$this, 'onTestFailed']);
        $listenerProvider->addListener([$this, 'onExecutionStopped']);
    }

    public function onExecutionStarted(Event\ExecutionStarted $event): void
    {
        $this->data = [
            'bootstraps' => [],
            'files' => [],
            'tests' => [],
            'counts' => [
                'files' => 0,
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

    public function onExecutionStopped(Event\ExecutionStopped $event): void
    {
        $this->data['counts']['files'] = count($this->data['files']);
        $this->getOutput()->writeln((string)json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
