<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Example\ExampleObj;

final class ExampleExited extends ExampleEvent
{
    public function __construct(ExampleObj $example)
    {
        parent::__construct(
            "Exited: {$example->getName()->getFullName()}",
            $example
        );
    }
}
