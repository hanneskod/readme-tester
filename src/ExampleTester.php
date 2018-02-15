<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\Status;
use hanneskod\readmetester\Runner\RunnerInterface;

/**
 * Run example code and evaluate expectations
 */
class ExampleTester
{
    /**
     * @var RunnerInterface
     */
    private $runner;

    /**
     * @var ExpectationEvaluator
     */
    private $evaluator;

    /**
     * @var ListenerInterface[]
     */
    private $listeners = [];

    public function __construct(RunnerInterface $runner, ExpectationEvaluator $evaluator)
    {
        $this->runner = $runner;
        $this->evaluator = $evaluator;
    }

    public function registerListener(ListenerInterface $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function testExample(Example $example): void
    {
        if (!$example->shouldBeEvaluated()) {
            foreach ($this->listeners as $listener) {
                $listener->onIgnoredExample($example);
            }
            return;
        }

        foreach ($this->listeners as $listener) {
            $listener->onExample($example);
        }

        $outcomes = $this->runner->run($example->getCodeBlock());

        foreach ($this->evaluator->evaluate($example->getExpectations(), $outcomes) as $status) {
            foreach ($this->listeners as $listener) {
                $listener->onExpectation($status);
            }
        }
    }
}
