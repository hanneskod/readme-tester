<?php

namespace hanneskod\readmetester;

/**
 * Test examples in readme file
 */
class ReadmeTester
{
    /**
     * @var ExampleFactory Helper to extract examples
     */
    private $exampleFactory;

    /**
     * Inject helpers
     *
     * @param ExampleFactory $exampleFactory
     */
    public function __construct(ExampleFactory $exampleFactory = null)
    {
        $this->exampleFactory = $exampleFactory ?: new ExampleFactory;
    }

    /**
     * Test examples in file
     *
     * @param  \SplFileObject         $file   File to extract examples from
     * @param  Format\FormatInterface $format Format used to identify examples
     * @return \Traversable
     */
    public function test(\SplFileObject $file, Format\FormatInterface $format)
    {
        foreach ($this->exampleFactory->createExamples($file, $format) as $example) {
            $result = $example->getCodeBlock()->execute();
            foreach ($example->getExpectations() as $expectation) {
                yield $example->getName() => $expectation->validate($result);
            }
        }
    }
}
