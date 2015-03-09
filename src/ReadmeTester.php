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
     * @param ExampleFactory|null $exampleFactory
     */
    public function __construct(ExampleFactory $exampleFactory = null)
    {
        $this->exampleFactory = $exampleFactory ?: new ExampleFactory;
    }

    /**
     * Test examples in file
     *
     * @param  FileInfo $file
     * @return string[] List of error messages
     */
    public function test(FileInfo $file)
    {
        $errors = array();

        foreach ($this->exampleFactory->createExamples($file) as $example) {
            try {
                $example->execute();
            } catch (RuntimeException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }
}
