<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

/**
 * Expect nothing
 */
class NullExpectation implements ExpectationInterface
{
    /**
     * Expect nothing
     */
    public function validate(Result $result)
    {
        return new ReturnObj\Success('Asserted nothing');
    }
}
