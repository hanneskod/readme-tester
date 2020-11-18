<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\StatusInterface;
use hanneskod\readmetester\Runner\OutcomeInterface;

abstract class TestEvent extends LogEvent
{
    private ExampleObj $example;
    private OutcomeInterface $outcome;
    private StatusInterface $status;

    public function __construct(ExampleObj $example, OutcomeInterface $outcome, StatusInterface $status)
    {
        parent::__construct("[{$example->getName()->getFullName()}] {$status->getDescription()}");

        $this->example = $example;
        $this->outcome = $outcome;
        $this->status = $status;
    }

    public function getExample(): ExampleObj
    {
        return $this->example;
    }

    public function getOutcome(): OutcomeInterface
    {
        return $this->outcome;
    }

    public function getStatus(): StatusInterface
    {
        return $this->status;
    }
}
