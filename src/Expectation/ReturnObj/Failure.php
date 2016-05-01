<?php

namespace hanneskod\readmetester\Expectation\ReturnObj;

/**
 * Represents a falure to evaluate an expectation
 */
class Failure extends ReturnObj
{
    public function isSuccess()
    {
        return false;
    }
}
