<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Evaluate expectations against a set of outcomes
 */
class ExpectationEvaluator
{
    /**
     * Evaluate expectations against a set of outcomes
     *
     * All outcomes must be handled by at least one expectation. Expectations
     * that does not handle an outcome defaults to failure.
     *
     * @param  ExpectationInterface[] $expectations
     * @param  OutcomeInterface[]     $outcomes
     * @return Status[]
     */
    public function evaluate(array $expectations, array $outcomes): array
    {
        $statuses = [];

        foreach ($expectations as $index => $expectation) {
            $statuses[$index] = new Failure("Failed $expectation");
        }

        foreach ($outcomes as $outcome) {
            $isHandled = false;

            foreach ($expectations as $index => $expectation) {
                if ($expectation->handles($outcome)) {
                    $statuses[$index] = $expectation->handle($outcome);
                    $isHandled = true;
                }
            }

            if (!$isHandled) {
                $statuses[] = new Failure("Unhandled $outcome");
            }
        }

        return $statuses;
    }
}
