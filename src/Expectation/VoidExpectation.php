<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Validate that no error and no output is generated
 */
final class VoidExpectation implements ExpectationInterface
{
    public function getDescription(): string
    {
        return 'expecting that no output and no error is produced';
    }

    public function handles(OutcomeInterface $outcome): bool
    {
        return true;
    }

    public function handle(OutcomeInterface $outcome): StatusInterface
    {
        if ($outcome->isOutput()) {
            return new Failure($outcome, "Failed asserting nothing, found output: {$outcome->getContent()}");
        }

        if ($outcome->isError()) {
            return new Failure($outcome, "Failed asserting nothing, found error: {$outcome->getContent()}");
        }

        return new Success($outcome, 'Asserted that no output and no error is produced');
    }
}
