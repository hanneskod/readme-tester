<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\EvalRunner;

/**
 * Test examples in readme file
 *
 * TODO rename Tester
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

    /**
     * @var RunnerInterface
     */
    private $runner;

    public function __construct(
        Parser $parser = null,
        ExampleFactory $exampleFactory = null,
        RunnerInterface $runner = null
    ) {
        // TODO remove default values. Create using a TesterFactory instead...
        $this->parser = $parser ?: new Parser;
        $this->exampleFactory = $exampleFactory ?: new ExampleFactory(new Expectation\ExpectationFactory);
        $this->runner = $runner ?: new EvalRunner;
    }

    /**
     * Test examples in file
     *
     * @param string $contents File contents to test examples in
     */
    public function test(string $contents): \Traversable
    {
        // TODO inject Evaluator...
        $evaluator = new Evaluator;

        foreach ($this->exampleFactory->createExamples(...$this->parser->parse($contents)) as $example) {
            $outcomes = $this->runner->run($example->getCodeBlock());

            foreach ($evaluator->evaluate($example->getExpectations(), $outcomes) as $status) {
                yield $example->getName() => $status;
            }
        }
    }
}
