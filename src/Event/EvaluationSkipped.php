<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Runner\OutcomeInterface;

final class EvaluationSkipped extends EvaluationEvent
{
    public function __construct(OutcomeInterface $outcome)
    {
        parent::__construct(
            "Skipped: {$outcome->getExample()->getName()->getFullName()} ({$outcome->getDescription()})",
            $outcome
        );
    }
}
