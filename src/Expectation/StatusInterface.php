<?php

namespace hanneskod\readmetester\Expectation;

/**
 * Represents the result of an evaluated expectation
 */
interface StatusInterface
{
    /**
     * Get a description of the represented status
     */
    public function getDescription(): string;

    /**
     * Check if expectation validation was a success
     */
    public function isSuccess(): bool;
}
