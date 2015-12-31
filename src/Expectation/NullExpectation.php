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
     *
     * @param  Result $result
     * @return null
     */
    public function validate(Result $result)
    {
    }
}
