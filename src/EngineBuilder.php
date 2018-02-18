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
use hanneskod\readmetester\Runner\EvalRunner;

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
                $this->filter ?: new NullFilter,
                $this->ignoreUnknownAnnotations
            ),
            new ExampleTester(
                $this->runner ?: new EvalRunner,
                new ExpectationEvaluator
            )
        );
    }
}
