<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

/**
 * Empty implementation of the filter interface
 */
class NullFilter implements FilterInterface
{
    public function isValid(string $name): bool
    {
        return true;
    }
}
