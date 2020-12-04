<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a falure to evaluate an expectation
 */
final class Failure extends AbstractStatus
{
    public function isSuccess(): bool
    {
        return false;
    }
}
