<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

final class ExecutionStarted extends LogEvent
{
    public function __construct()
    {
        parent::__construct('Execution started');
    }
}
