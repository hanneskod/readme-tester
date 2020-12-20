<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

class TestingAborted extends BaseEvent
{
    public function __construct()
    {
        parent::__construct("Aborting");
    }
}
