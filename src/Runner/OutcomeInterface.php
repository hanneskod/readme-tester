<?php

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

/**
 * Represents an outcome (effect) of an executed example
 */
interface OutcomeInterface
{
    /**
     * Get the actual outcome data
     */
    public function getContent(): string;

    /**
     * Get a free text description of this outcome
     */
    public function getDescription(): string;

    /**
     * Get example this outcome originates from
     */
    public function getExample(): ExampleObj;

    /**
     * Check if unhandled outcome should trigger an error
     */
    public function mustBeHandled(): bool;

    /**
     * Check if this is an error outcome
     */
    public function isError(): bool;

    /**
     * Check if this is an output outcome
     */
    public function isOutput(): bool;

    /**
     * Check if this is a skipped outcome
     */
    public function isSkipped(): bool;

    /**
     * Check if this is a void outcome
     */
    public function isVoid(): bool;
}
