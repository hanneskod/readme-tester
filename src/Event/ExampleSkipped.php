<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Runner\OutcomeInterface;

final class ExampleSkipped extends ExampleEvent
{
    private OutcomeInterface $outcome;

    public function __construct(ExampleObj $example, OutcomeInterface $outcome)
    {
        parent::__construct(
            "Skipped: {$example->getName()->getFullName()}: {$outcome->getDescription()}",
            $example
        );

        $this->outcome = $outcome;
    }

    public function getOutcome(): OutcomeInterface
    {
        return $this->outcome;
    }
}
