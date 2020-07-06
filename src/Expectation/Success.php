<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents a successfully evaluated expectation
 */
final class Success implements StatusInterface
{
    private string $desc;

    public function __construct(string $desc)
    {
        $this->desc = $desc;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }

    public function isSuccess(): bool
    {
        return true;
    }
}
