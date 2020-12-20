<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

final class ExitStatusListener
{
    private int $exitStatus = 0;

    public function onTestFailed(TestFailed $event): void
    {
        $this->exitStatus = 1;
    }

    public function onInvalidInput(InvalidInput $event): void
    {
        $this->exitStatus = 1;
    }

    public function getStatusCode(): int
    {
        return $this->exitStatus;
    }
}
