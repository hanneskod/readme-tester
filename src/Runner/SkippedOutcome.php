<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

final class SkippedOutcome implements OutcomeInterface
{
    use OutcomeDefaultsTrait;

    public function __construct(
        private ExampleObj $example,
        private string $description,
    ) {}

    public function isSkipped(): bool
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
        return $this->description;
    }
}
