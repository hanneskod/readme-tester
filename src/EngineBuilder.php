<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Runner\RunnerInterface;

class EngineBuilder
{
    private RunnerInterface $runner;

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
