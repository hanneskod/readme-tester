<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation\ReturnObj;

/**
 * Represents the result of an evaluated expectation
 */
abstract class ReturnObj
{
    /**
     * @var string
     */
    private $message;

    /**
     * Set returned message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get returned message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Check if expectation validation was a failure
     */
    public function isFailure(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Check if expectation validation was a success
     */
    abstract public function isSuccess(): bool;
}
