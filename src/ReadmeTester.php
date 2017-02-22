<?php

declare(strict_types = 1);

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
        $this->exampleFactory = $exampleFactory ?: new ExampleFactory(new Expectation\ExpectationFactory);
    }

    /**
     * Test examples in file
     *
     * @param string $contents File contents to test examples in
     */
    public function test(string $contents): \Traversable
    {
        foreach ($this->exampleFactory->createExamples($this->parser->parse($contents)) as $example) {
            $result = $example->getCodeBlock()->execute();
            foreach ($example->getExpectations() as $expectation) {
                yield $example->getName() => $expectation->validate($result);
            }
        }
    }
}
