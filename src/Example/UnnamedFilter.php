<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

/**
 * Filter examples with empty name
 */
class UnnamedFilter implements FilterInterface
{
    public function isValid(string $name): bool
    {
        return !!$name;
    }
}
