<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Runner\OutcomeInterface;

abstract class EvaluationEvent extends BaseEvent
{
    private OutcomeInterface $outcome;

    public function __construct(string $message, OutcomeInterface $outcome)
    {
        parent::__construct($message);
        $this->outcome = $outcome;
    }

    public function getOutcome(): OutcomeInterface
    {
        return $this->outcome;
    }
}
