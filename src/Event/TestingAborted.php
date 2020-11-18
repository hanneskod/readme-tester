<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

class TestingAborted extends DebugEvent
{
    public function __construct()
    {
        parent::__construct("Aborting");
    }
}
