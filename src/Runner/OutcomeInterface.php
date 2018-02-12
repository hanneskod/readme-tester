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
     * Return type identifier
     */
    const TYPE_RETURN = 'TYPE_RETURN';

    /**
     * Exception type identifier
     */
    const TYPE_EXCEPTION = 'TYPE_EXCEPTION';

    /**
     * Convert outcome to string
     */
    public function __tostring(): string;

    /**
     * Get a token describing the outcome type
     *
     * See the list of type constants in OutcomeInterface
     */
    public function getType(): string;

    /**
     * Get the actual outcome data
     *
     * The structure of the returned array may differ in the various outcomes
     */
    public function getPayload(): array;
}
