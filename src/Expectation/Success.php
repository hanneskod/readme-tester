<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a successfully evaluated expectation
 */
class Success extends Status
{
    public function isSuccess(): bool
    {
        return true;
    }
}
