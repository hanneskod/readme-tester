<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

final class VoidOutcome implements OutcomeInterface
{
    use OutcomeDefaultsTrait;

    public function __construct(
        private ExampleObj $example,
    ) {}

    public function isVoid(): bool
    {
        return true;
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
