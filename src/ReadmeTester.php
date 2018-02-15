<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Expectation\Status;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;

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
    public function test(string $contents): iterable
    {
        $tester = new ExampleTester(
            new EvalRunner,
            new ExpectationEvaluator
        );

        $listener = new class implements ListenerInterface {
            private $example;

            public $statuses = [];

            function onExample(Example $example): void
            {
                $this->example = $example;
            }

            function onIgnoredExample(Example $example): void
            {
            }

            function onExpectation(Status $status): void
            {
                $this->statuses[] = [$this->example->getName(), $status];
            }
        };

        $tester->registerListener($listener);

        foreach ($this->exampleFactory->createExamples(...$this->parser->parse($contents)) as $example) {
            $tester->testExample($example);
        }

        foreach ($listener->statuses as $vals) {
            yield $vals[0] => $vals[1];
        };
    }
}
