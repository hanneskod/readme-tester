<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

final class VoidOutcome implements OutcomeInterface
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

    public function getDescription(): string
    {
        return 'void outcome';
    }
}
