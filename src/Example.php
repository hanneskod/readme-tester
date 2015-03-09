<?php

namespace hanneskod\readmetester;

use UnexpectedValueException;

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
     * @var Expectation[] List of expectations
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
     * Add line to example code
     *
     * @param  string $line
     * @return null
     */
    public function addLine($line)
    {
        $this->code .= $line . PHP_EOL;
    }

    /**
     * Add expectation to example
     *
     * @param  Expectation $expectation
     * @return null
     */
    public function addExpectation(Expectation $expectation)
    {
        $this->expectations[] = $expectation;
    }

    /**
     * Execute example code and validate result
     *
     * @return null
     * @throws UnexpectedValueException If example is not valid
     */
    public function execute()
    {
        try {
            $result = (new CodeBlock($this->code))->execute();
            foreach ($this->expectations as $expectation) {
                $expectation->validate($result);
            }
        } catch (UnexpectedValueException $e) {
            throw new UnexpectedValueException("Example {$this->name}: {$e->getMessage()}");
        }
    }
}
