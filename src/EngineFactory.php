<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\FilterInterface;
use hanneskod\readmetester\Example\NullFilter;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Runner\EvalRunner;

class EngineFactory
{
    public function createEngine(FilterInterface $filter = null, bool $ignoreUnknownAnnotations = false): Engine
    {
        return new Engine(
            new Parser,
            new ExampleFactory(
                new ExpectationFactory,
                $filter ?: new NullFilter,
                $ignoreUnknownAnnotations
            ),
            new ExampleTester(
                new EvalRunner,
                new ExpectationEvaluator
            )
        );
    }
}
