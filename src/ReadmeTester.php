<?php

namespace hanneskod\readmetester;

use RuntimeException;

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
     * @return string[] List of error messages
     */
    public function test(\SplFileObject $file, Format\FormatInterface $format)
    {
        $errors = array();

        foreach ($this->exampleFactory->createExamples($file, $format) as $example) {
            try {
                $example->execute();
            } catch (RuntimeException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }
}
