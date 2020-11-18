<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

final class ErrorOutcome implements OutcomeInterface
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getType(): string
    {
        return self::TYPE_ERROR;
    }

    public function mustBeHandled(): bool
    {
        return true;
    }

    public function getContent(): string
    {
        return $this->message;
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
        return $this->message;
    }
}
