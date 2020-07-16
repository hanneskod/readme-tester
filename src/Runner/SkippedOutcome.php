<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

final class SkippedOutcome implements OutcomeInterface
{
    private string $desc;

    public function __construct(string $desc)
    {
        $this->desc = $desc;
    }

    public function getType(): string
    {
        return self::TYPE_SKIPPED;
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
        return $this->desc;
    }
}
