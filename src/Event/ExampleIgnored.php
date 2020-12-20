<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Example\ExampleObj;

final class ExampleIgnored extends ExampleEvent
{
    public function __construct(ExampleObj $example)
    {
        parent::__construct(
            "Ignored: {$example->getName()->getFullName()}",
            $example
        );
    }
}
