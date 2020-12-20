<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

use hanneskod\readmetester\Runner\OutcomeInterface;

final class EvaluationDone extends EvaluationEvent
{
    public function __construct(OutcomeInterface $outcome)
    {
        parent::__construct(
            "Exited: {$outcome->getExample()->getName()->getFullName()}",
            $outcome
        );
    }
}
