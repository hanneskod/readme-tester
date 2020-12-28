<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

abstract class AbstractStatus implements StatusInterface
{
    public function __construct(
        private OutcomeInterface $outcome,
        private string $content,
    ) {}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTruncatedContent(int $strlen = 60): string
    {
        $content = trim($this->getContent());

        if (mb_strlen($content) <= $strlen) {
            return $content;
        }

        return mb_substr($content, 0, $strlen - 3) . '...';
    }

    public function getOutcome(): OutcomeInterface
    {
        return $this->outcome;
    }
}
