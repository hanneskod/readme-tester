<?php

namespace hanneskod\readmetester;

/**
 * Test examples in readme file
 */
class ReadmeTester
{
    /**
     * @var Parser Helper to extract example definitions
     */
    private $parser;

    /**
     * @var ExampleFactory Helper to create example objects
     */
    private $exampleFactory;

    public function __construct(Parser $parser = null, ExampleFactory $exampleFactory = null)
    {
        $this->parser = $parser ?: new Parser;
        $this->exampleFactory = $exampleFactory ?: new ExampleFactory;
    }

    /**
     * Test examples in file
     *
     * @param  string $contents File contents to test examples in
     * @return \Traversable
     */
    public function test($contents)
    {
        foreach ($this->exampleFactory->createExamples($this->parser->parse($contents)) as $example) {
            $result = $example->getCode()->execute();
            foreach ($example->getExpectations() as $expectation) {
                yield $example->getName() => $expectation->validate($result);
            }
        }
    }
}
