<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use hanneskod\readmetester\ListenerInterface;
use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Expectation\Status;

/**
 * Capture exit status
 */
class ExitStatusListener implements ListenerInterface
{
    /**
     * @var int
     */
    private $exitStatus = 0;

    public function onExample(Example $example): void
    {
    }

    public function onIgnoredExample(Example $example): void
    {
    }

    public function onExpectation(Status $status): void
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
