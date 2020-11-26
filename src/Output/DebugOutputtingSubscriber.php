<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;

final class DebugOutputtingSubscriber extends AbstractOutputtingSubscriber
{
    public function onExecutionStarted(Event\ExecutionStarted $event): void
    {
        $this->setOutput($event->getOutput());
    }

    public function onDebugEvent(Event\DebugEvent $event): void
    {
        $this->getOutput()->writeln($event->getMessage());
    }
}
