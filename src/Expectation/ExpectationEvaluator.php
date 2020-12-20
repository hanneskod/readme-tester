<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ExpectationEvaluator
{
    /**
     * Evaluate expectations against an outcome
     *
     * If outcome is marked as mustBeHandled it must be handled by at least one
     * expectation. Expectations that does not handle an outcome triggers failure.
     *
     * @return array<StatusInterface>
     */
    public function evaluate(OutcomeInterface $outcome): array
    {
        $statuses = [];
        $isHandled = !$outcome->mustBeHandled();

        foreach ($outcome->getExample()->getExpectations() as $index => $expectation) {
            if ($expectation->handles($outcome)) {
                $statuses[$index] = $expectation->handle($outcome);
                $isHandled = true;
            } else {
                $statuses[$index] = new Failure($outcome, "Failed {$expectation->getDescription()}");
            }
        }

        if (!$isHandled) {
            $statuses[] = new Failure($outcome, 'Unhandled ' . $outcome->getDescription());
        }

        return $statuses;
    }
}
