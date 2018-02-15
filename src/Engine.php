<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Parser\Parser;

/**
 * Test examples in file
 */
class Engine
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var ExampleFactory
     */
    private $exampleFactory;

    /**
     * @var ExampleTester
     */
    private $tester;

    public function __construct(Parser $parser, ExampleFactory $exampleFactory, ExampleTester $tester)
    {
        $this->parser = $parser;
        $this->exampleFactory = $exampleFactory;
        $this->tester = $tester;
    }

    public function registerListener(ListenerInterface $listener): void
    {
        $this->tester->registerListener($listener);
    }

    /**
     * Test examples in file
     */
    public function testFile(string $contents): void
    {
        foreach ($this->exampleFactory->createExamples(...$this->parser->parse($contents)) as $example) {
            $this->tester->testExample($example);
        }
    }
}
