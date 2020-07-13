<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Runner\RunnerInterface;

final class ExampleTester
{
    private RunnerInterface $runner;
    private ExpectationEvaluator $evaluator;
    private bool $stopOnFailure;

    /**
     * @var ListenerInterface[]
     */
    private $listeners = [];

    public function __construct(RunnerInterface $runner, ExpectationEvaluator $evaluator, bool $stopOnFailure)
    {
        $this->runner = $runner;
        $this->evaluator = $evaluator;
        $this->stopOnFailure = $stopOnFailure;
    }

    public function registerListener(ListenerInterface $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function test(ExampleStoreInterface $exampleStore): void
    {
        foreach ($exampleStore->getExamples() as $example) {
            if (!$example->isActive()) {
                foreach ($this->listeners as $listener) {
                    $listener->onIgnoredExample($example);
                }
                continue;
            }

            foreach ($this->listeners as $listener) {
                $listener->onExample($example);
            }

            $outcome = $this->runner->run($example->getCodeBlock());

            foreach ($this->evaluator->evaluate($example->getExpectations(), $outcome) as $status) {
                foreach ($this->listeners as $listener) {
                    $listener->onExpectation($status);
                }

                if ($this->stopOnFailure && !$status->isSuccess()) {
                    break 2;
                }
            }
        }
    }
}
