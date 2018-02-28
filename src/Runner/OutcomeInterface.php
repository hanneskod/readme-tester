<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Represents an outcome (effect) of an executed code block
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
     * Get a token describing the outcome type
     *
     * See the list of type constants in OutcomeInterface
     */
    public function getType(): string;

    /**
     * Check unhandled outcome should trigger an error
     */
    public function mustBeHandled(): bool;

    /**
     * Get the actual outcome data
     */
    public function getContent(): string;

    /**
     * Get a free text description of this outcome
     */
    public function __tostring(): string;
}
