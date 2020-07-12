<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\ProcessorInterface;
use hanneskod\readmetester\Example\ProcessorContainer;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Runner\RunnerInterface;

class EngineBuilder
{
    private ProcessorInterface $processor;
    private RunnerInterface $runner;

    public function __construct()
    {
        $this->processor = new ProcessorContainer;
    }

    public function setProcessor(ProcessorInterface $processor): self
    {
        $this->processor = $processor;
        return $this;
    }

    public function setRunner(RunnerInterface $runner): self
    {
        $this->runner = $runner;
        return $this;
    }

    public function buildEngine(): Engine
    {
        return new Engine(
            new Parser,
            new ExampleFactory(
                new ExpectationFactory,
                $this->processor
            ),
            new ExampleTester(
                $this->getRunner(),
                new ExpectationEvaluator
            )
        );
    }

    private function getRunner(): RunnerInterface
    {
        if (!isset($this->runner)) {
            throw new \LogicException('Unable to create engine, runner not set');
        }

        return $this->runner;
    }
}
