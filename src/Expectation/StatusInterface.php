<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

/**
 * Represents the result of an evaluated expectation
 */
interface StatusInterface
{
    /**
     * Get a full description of the represented status
     */
    public function getContent(): string;

    /**
     * Get a truncated version of status content
     */
    public function getTruncatedContent(int $strlen = 60): string;

    /**
     * Get outcome this status originates from
     */
    public function getOutcome(): OutcomeInterface;

    /**
     * Check if expectation validation was a success
     */
    public function isSuccess(): bool;
}
