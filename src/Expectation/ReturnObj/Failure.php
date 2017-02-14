<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation\ReturnObj;

/**
 * Represents a falure to evaluate an expectation
 */
class Failure extends ReturnObj
{
    public function isSuccess(): bool
    {
        return false;
    }
}
