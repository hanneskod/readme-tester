<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\FilterInterface;
use hanneskod\readmetester\Example\NullFilter;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Runner\RunnerInterface;

class EngineBuilder
{
    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @var RunnerInterface
     */
    private $runner;

    /**
     * @var bool
     */
    private $ignoreUnknownAnnotations = false;

    public function __construct()
    {
        $this->filter = new NullFilter;
    }

    public function setIgnoreUnknownAnnotations($flag = true)
    {
        $this->ignoreUnknownAnnotations = $flag;
    }

    public function setFilter(FilterInterface $filter): self
    {
        $this->filter = $filter;
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
                $this->getFilter(),
                $this->ignoreUnknownAnnotations
            ),
            new ExampleTester(
                $this->getRunner(),
                new ExpectationEvaluator
            )
        );
    }

    private function getFilter(): FilterInterface
    {
        return $this->filter;
    }

    private function getRunner(): RunnerInterface
    {
        if (!isset($this->runner)) {
            throw new \LogicException('Unable to create engine, runner not set');
        }

        return $this->runner;
    }
}
