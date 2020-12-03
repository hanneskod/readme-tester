<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Config;

final class Suite
{
    /**
     * @param array<string> $includePaths
     * @param array<string> $excludePaths
     * @param array<string> $fileExtensions
     * @param array<string> $globalAttributes
     */
    public function __construct(
        private string $name,
        private bool $active = true,
        private string $inputLanguage = '',
        private string $runner = '',
        private array $includePaths = [],
        private array $excludePaths = [],
        private array $fileExtensions = [],
        private array $globalAttributes = [],
        private bool $stopOnFailure = false,
    ) {}

    public function getSuiteName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getInputLanguage(): string
    {
        return $this->inputLanguage;
    }

    public function getRunner(): string
    {
        return $this->runner;
    }

    /** @return array<string> */
    public function getIncludePaths(): array
    {
        return $this->includePaths;
    }

    /** @return array<string> */
    public function getExcludePaths(): array
    {
        return $this->excludePaths;
    }

    /** @return array<string> */
    public function getFileExtensions(): array
    {
        return $this->fileExtensions;
    }

    /** @return array<string> */
    public function getGlobalAttributes(): array
    {
        return $this->globalAttributes;
    }

    public function stopOnFailure(): bool
    {
        return $this->stopOnFailure;
    }
}
