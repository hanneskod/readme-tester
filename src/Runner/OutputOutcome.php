<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

final class OutputOutcome implements OutcomeInterface
{
    use OutcomeDefaultsTrait;

    public function __construct(
        private ExampleObj $example,
        private string $content,
    ) {}

    public function isOutput(): bool
    {
        return true;
    }

    public function mustBeHandled(): bool
    {
        return true;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDescription(): string
    {
        return "output '{$this->getContent()}'";
    }
}
