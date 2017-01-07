<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationFactory;

/**
 * Create examples from definitions created by Parser
 */
class ExampleFactory
{
    /**
     * @var ExpectationFactory
     */
    private $expectationFactory;

    public function __construct(ExpectationFactory $expectationFactory = null)
    {
        $this->expectationFactory = $expectationFactory ?: new ExpectationFactory;
    }

    /**
     * Create examples from definitions
     *
     * @param  array $defenitions Example definitions as created by Parser
     * @return Example[]
     */
    public function createExamples(array $defenitions)
    {
        $examples = [];

        foreach ($defenitions as $index => $def) {
            if ($this->shouldIgnoreExample($def['annotations'])) {
                continue;
            }

            $name = $this->readName($def['annotations']) ?: (string)$index + 1;

            if (isset($examples[$name])) {
                throw new \RuntimeException("Example '$name' already exists in definition " . ($index + 1));
            }

            $examples[$name] = new Example(
                $name,
                new CodeBlock($def['code']),
                $this->createExpectations($def['annotations'])
            );
        }

        return $examples;
    }

    /**
     * Read name from example annotation
     *
     * @return string
     */
    private function readName(array $annotations)
    {
        foreach ($annotations as list($name, $args)) {
            if (strcasecmp($name, 'example') == 0) {
                return isset($args[0]) ? $args[0] : '';
            }
        }

        return '';
    }

    /**
     * Check if this example is marked as ignored
     *
     * @return boolean
     */
    private function shouldIgnoreExample(array $annotations)
    {
        foreach ($annotations as list($name, $args)) {
            if (strcasecmp($name, 'ignore') == 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create expectation from definition data
     *
     * @return Expectation\ExpectationInterface[]
     */
    private function createExpectations(array $annotations)
    {
        $expectations = [];

        foreach ($annotations as list($name, $args)) {
            $expectations[] = $this->expectationFactory->createExpectation($name, $args);
        }

        return array_filter($expectations);
    }
}
