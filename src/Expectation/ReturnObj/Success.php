<?php

namespace hanneskod\readmetester\Expectation\ReturnObj;

/**
 * Represents a successfully evaluated expectation
 */
class Success extends ReturnObj
{
    public function isSuccess()
    {
        return true;
    }
}
