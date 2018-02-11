<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Container for the result of an executed code block
 */
class Result
{
    /**
     * @var mixed Data return by executed code
     */
    private $returnValue;

    /**
     * @var string Output made by executed code
     */
    private $output;

    /**
     * @var \Exception Exception thrown by executed code
     */
    private $exception;

    /**
     * Construct result object
     *
     * @param mixed           $returnValue Data return by executed code
     * @param string          $output      Output made by executed code
     * @param \Exception|null $exception   Exception thrown by executed code
     */
    public function __construct($returnValue, string $output, \Exception $exception = null)
    {
        $this->returnValue = $returnValue;
        $this->output = $output;
        $this->exception = $exception;
    }

    /**
     * Get data returned by executed code
     *
     * @return mixed
     */
    public function getReturnValue()
    {
        return $this->returnValue;
    }

    /**
     * Get output made by executed code
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * Get exception thrown by executed code
     *
     * @return \Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }
}
