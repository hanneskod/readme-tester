<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Example\ExampleObj;

abstract class ExampleEvent extends LogEvent
{
    private ExampleObj $example;

    public function __construct(string $message, ExampleObj $example)
    {
        parent::__construct($message);
        $this->example = $example;
    }

    public function getExample(): ExampleObj
    {
        return $this->example;
    }
}
