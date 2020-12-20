<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Config\Suite;

abstract class SuiteEvent extends BaseEvent
{
    private Suite $suite;

    public function __construct(string $message, Suite $suite)
    {
        parent::__construct($message);
        $this->suite = $suite;
    }

    public function getSuite(): Suite
    {
        return $this->suite;
    }
}
