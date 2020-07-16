<?php

namespace hanneskod\readmetester\Runner;

/**
 * Represents an outcome (effect) of an executed example
 */
interface OutcomeInterface
{
    /**
     * Output type identifier
     */
    const TYPE_OUTPUT = 'TYPE_OUTPUT';

    /**
     * Error type identifier
     */
    const TYPE_ERROR = 'TYPE_ERROR';

    /**
     * Void type identifier
     */
    const TYPE_VOID = 'TYPE_VOID';

    /**
     * Skipped type identifier
     */
    const TYPE_SKIPPED = 'TYPE_SKIPPED';

    /**
     * Get a token describing the outcome type
     *
     * See the list of type constants in OutcomeInterface
     */
    public function getType(): string;

    /**
     * Check if unhandled outcome should trigger an error
     */
    public function mustBeHandled(): bool;

    /**
     * Get the actual outcome data
     */
    public function getContent(): string;

    /**
     * Get a free text description of this outcome
     */
    public function getDescription(): string;
}
