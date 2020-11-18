<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

final class OutputOutcome implements OutcomeInterface
{
    private string $output;

    public function __construct(string $output)
    {
        $this->output = $output;
    }

    public function getType(): string
    {
        return self::TYPE_OUTPUT;
    }

    public function mustBeHandled(): bool
    {
        return true;
    }

    public function getContent(): string
    {
        return $this->output;
    }

    public function getTruncatedContent(int $strlen = 30): string
    {
        $content = trim($this->getContent());

        if (mb_strlen($content) <= $strlen) {
            return $content;
        }

        return mb_substr($content, 0, $strlen-3) . '...';
    }

    public function getDescription(): string
    {
        return "output '{$this->output}'";
    }
}
