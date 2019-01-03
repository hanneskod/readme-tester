<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Evaluate expectations against an outcome
 */
class ExpectationEvaluator
{
    /**
     * Evaluate expectations against an outcome
     *
     * If outcome is marked as mustBeHandled it must be handled by at least one
     * expectation. Expectations that does not handle an outcome triggers failure.
     *
     * @param  ExpectationInterface[] $expectations
     * @param  OutcomeInterface       $outcome
     * @return StatusInterface[]
     */
    public function evaluate(array $expectations, OutcomeInterface $outcome): array
    {
        $statuses = [];
        $isHandled = !$outcome->mustBeHandled();

        foreach ($expectations as $index => $expectation) {
            if ($expectation->handles($outcome)) {
                $statuses[$index] = $expectation->handle($outcome);
                $isHandled = true;
            } else {
                $statuses[$index] = new Failure("Failed {$expectation->getDescription()}");
            }
        }

        if (!$isHandled) {
            $statuses[] = new Failure("Unhandled {$outcome->getDescription()}");
        }

        return $statuses;
    }
}
