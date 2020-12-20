<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Config\Suite;

final class SuiteDone extends SuiteEvent
{
    public function __construct(Suite $suite)
    {
        parent::__construct("Suite {$suite->getSuiteName()} done", $suite);
    }
}
