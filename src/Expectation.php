<?php

namespace hanneskod\readmetester;

/**
 * Validate the result of an executed code block
 */
interface Expectation
{
    /**
     * Validate result object
     *
     * @param  Result $result
     * @return null
     * @throws \UnexpectedValueException If result is not valid
     */
    public function validate(Result $result);
}
