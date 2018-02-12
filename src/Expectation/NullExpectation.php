<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

/**
 * Expect nothing
 */
class NullExpectation implements ExpectationInterface
{
    /**
     * Expect nothing
     */
    public function validate(Result $result): Status
    {
        return new Success('Asserted nothing');
    }
}
