<?php

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
     * Set message
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get returned message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Check if expectation validation was a failure
     *
     * @return boolean
     */
    public function isFailure()
    {
        return !$this->isSuccess();
    }

    /**
     * Check if expectation validation was a success
     *
     * @return boolean
     */
    abstract public function isSuccess();
}
