<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

/**
 * Validate the result of an executed code block
 */
interface ExpectationInterface
{
    /**
     * Validate result object
     *
     * @param  Result $result
     * @return ReturnObj\ReturnObj
     */
    public function validate(Result $result);
}
