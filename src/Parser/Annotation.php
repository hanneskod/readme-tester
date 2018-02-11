<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Parser;

/**
 * Annotation value object
 */
class Annotation
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $arguments;

    public function __construct(string $name, string ...$arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * Get annotation name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Check if annotation name matches name in a case insensitive manner
     */
    public function isNamed(string $name): bool
    {
        return !strcasecmp($name, $this->getName());
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param integer $index Optional index of argument to read
     */
    public function getArgument(int $index = 0): string
    {
        if (!isset($this->arguments[$index])) {
            throw new \LogicException("Annotation @{$this->getName()} missing argument $index");
        }

        return $this->arguments[$index];
    }
}
