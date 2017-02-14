<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation\ReturnObj;

/**
 * Represents a successfully evaluated expectation
 */
class Success extends ReturnObj
{
    public function isSuccess(): bool
    {
        return true;
    }
}
