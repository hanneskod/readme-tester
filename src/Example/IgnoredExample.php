<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Parser\CodeBlock;

/**
 * An example that should not be evaluated
 */
class IgnoredExample extends Example
{
    public function isActive(): bool
    {
        return false;
    }
}
