<?php

namespace hanneskod\readmetester;

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
     * @var string Example code
     */
    private $code = '';

    /**
     * @var Expectation\ExpectationInterface[] List of expectations
     */
    private $expectations = array();

    /**
     * Set name of example
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
     * Add line to example code
     *
     * @param  string $line
     * @return null
     */
    public function addLine($line)
    {
        $this->code .= $line;
    }

    /**
     * Get example code block
     *
     * @return CodeBlock
     */
    public function getCodeBlock()
    {
        return new CodeBlock($this->code);
    }

    /**
     * Add expectation to example
     *
     * @param  Expectation\ExpectationInterface $expectation
     * @return null
     */
    public function addExpectation(Expectation\ExpectationInterface $expectation)
    {
        $this->expectations[] = $expectation;
    }

    /**
     * Get registered expectations
     *
     * @return Expectation\ExpectationInterface[]
     */
    public function getExpectations()
    {
        return $this->expectations;
    }
}
