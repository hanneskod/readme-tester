<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Empty outcome
 */
class VoidOutcome implements OutcomeInterface
{
    public function getType(): string
    {
        return self::TYPE_VOID;
    }

    public function mustBeHandled(): bool
    {
        return false;
    }

    public function getContent(): string
    {
        return '';
    }

    public function __tostring(): string
    {
        return 'void outcome';
    }
}
