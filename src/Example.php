<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationInterface;

/**
 * Wrapper around a block of code and it's expectations
 */
class Example
{
    /**
     * @var string Name of this example
     */
    private $name;

    /**
     * @var CodeBlock Example code
     */
    private $code;

    /**
     * @var ExpectationInterface[] List of expectations
     */
    private $expectations;

    /**
     * @param string $name
     */
    public function __construct($name, CodeBlock $code, array $expectations)
    {
        $this->name = $name;
        $this->code = $code;
        $this->expectations = $expectations;
    }

    /**
     * Get name of example
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get example code block
     *
     * @return CodeBlock
     */
    public function getCodeBlock()
    {
        return $this->code;
    }

    /**
     * Get registered expectations
     *
     * @return ExpectationInterface[]
     */
    public function getExpectations()
    {
        return $this->expectations;
    }
}
