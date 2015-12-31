<?php

namespace hanneskod\readmetester;

/**
 * Extract examples from text file
 */
class ExampleFactory
{
    /**
     * Regular expression to catch expection annotations
     */
    const ANNOTATION_REGEXP = '/^<!-{2,3}\s+@([a-z]+)(.*)-->\s*/i';

    /**
     * @var FormatFactory Helper to identify file format
     */
    private $formatFactory;

    /**
     * @var ExpectationFactory Helper to create expectations
     */
    private $expectationFactory;

    /**
     * Inject helpers
     *
     * @param FormatFactory|null $formatFactory
     * @param ExpectationFactory|null $expectationFactory
     */
    public function __construct(FormatFactory $formatFactory = null, ExpectationFactory $expectationFactory = null)
    {
        $this->formatFactory = $formatFactory ?: new FormatFactory;
        $this->expectationFactory = $expectationFactory ?: new ExpectationFactory;
    }

    /**
     * Extract examples from file
     *
     * @param  \SplFileObject $file
     * @return Example[]
     */
    public function createExamples(\SplFileObject $file)
    {
        $exampleId = 1;
        $examples = array();
        $current = new Example($exampleId);
        $inCodeBlock = false;
        $ignoreNext = false;
        $format = $this->formatFactory->createFormat($file);

        foreach ($file as $line) {
            if ($inCodeBlock) {
                if ($format->isExampleEnd($line)) {
                    $examples[$exampleId++] = $current;
                    $current = new Example($exampleId);
                    $inCodeBlock = false;
                    continue;
                }
                $current->addLine($line);
            } elseif ($format->isExampleStart($line)) {
                $inCodeBlock = true;
                if ($ignoreNext) {
                    $current = new Example(++$exampleId);
                    $ignoreNext = false;
                    $inCodeBlock = false;
                }
            } elseif ($this->isIgnoreAnnotation($line)) {
                $ignoreNext = true;
            } elseif ($expectation = $this->readExpectation($line)) {
                $current->addExpectation($expectation);
            }
        }

        return $examples;
    }

    /**
     * Check if line is a ignore anntotation
     *
     * @param  string $line
     * @return boolean
     */
    private function isIgnoreAnnotation($line)
    {
        if (preg_match(self::ANNOTATION_REGEXP, $line, $matches)) {
            return 'ignore' == strtolower($matches[1]);
        }
    }

    /**
     * Parse expectation from line
     *
     * @param  string $line
     * @return Expectation|null
     */
    private function readExpectation($line)
    {
        if (preg_match(self::ANNOTATION_REGEXP, $line, $matches)) {
            return $this->expectationFactory->createExpectation($matches[1], trim($matches[2]));
        }
    }
}
