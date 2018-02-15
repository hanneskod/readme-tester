<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

/**
 * Example filter based on example names
 */
interface FilterInterface
{
    /**
     * Check if name should be keept or filtered
     */
    public function isValid(string $name): bool;
}
