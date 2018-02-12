<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

/**
 * Represents the result of an evaluated expectation
 */
abstract class Status
{
    /**
     * @var string
     */
    private $desc;

    public function __construct(string $desc)
    {
        $this->desc = $desc;
    }

    /**
     * Get a description of the represented status
     */
    public function __tostring(): string
    {
        return $this->desc;
    }

    /**
     * Check if expectation validation was a success
     */
    abstract public function isSuccess(): bool;
}
