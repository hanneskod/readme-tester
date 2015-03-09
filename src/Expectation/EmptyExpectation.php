<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation;
use hanneskod\readmetester\Result;

/**
 * Expect nothing
 */
class EmptyExpectation implements Expectation
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
