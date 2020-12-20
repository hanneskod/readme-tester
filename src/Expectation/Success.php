<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a successfully evaluated expectation
 */
final class Success extends AbstractStatus
{
    public function isSuccess(): bool
    {
        return true;
    }
}
