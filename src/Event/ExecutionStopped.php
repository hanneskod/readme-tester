<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

final class ExecutionStopped extends BaseEvent
{
    public function __construct()
    {
        parent::__construct('Execution stopped');
    }
}
