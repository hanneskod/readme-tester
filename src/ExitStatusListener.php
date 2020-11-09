<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\StatusInterface;

/**
 * Capture exit status
 */
final class ExitStatusListener implements ListenerInterface
{
    private int $exitStatus = 0;

    public function onExample(ExampleObj $example): void
    {
    }

    public function onIgnoredExample(ExampleObj $example): void
    {
    }

    public function onExpectation(StatusInterface $status): void
    {
        if (!$status->isSuccess()) {
            $this->exitStatus = 1;
        }
    }

    public function getStatusCode(): int
    {
        return $this->exitStatus;
    }
}
