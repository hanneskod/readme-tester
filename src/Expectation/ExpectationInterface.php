<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Validate the result of an executed code block
 */
interface ExpectationInterface
{
    /**
     * Get a free text description of expectation
     */
    public function getDescription(): string;

    /**
     * Check if this expectation handles an outcome
     */
    public function handles(OutcomeInterface $outcome): bool;

    /**
     * Handle outcome
     */
    public function handle(OutcomeInterface $outcome): StatusInterface;
}
