<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a falure to evaluate an expectation
 */
class Failure extends Status
{
    public function isSuccess(): bool
    {
        return false;
    }
}
