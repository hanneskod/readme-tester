<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Event;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\SkippedOutcome;
use Psr\EventDispatcher\EventDispatcherInterface;

final class ExampleTester
{
    public function __construct(
        private ExpectationEvaluator $evaluator,
        private EventDispatcherInterface $dispatcher,
    ) {}

    public function test(ExampleStoreInterface $exampleStore, RunnerInterface $runner, bool $stopOnFailure): void
    {
        foreach ($runner->run($exampleStore) as $outcome) {
            if ($outcome instanceof SkippedOutcome) {
                $this->dispatcher->dispatch(new Event\EvaluationSkipped($outcome));
                continue;
            }

            $this->dispatcher->dispatch(new Event\EvaluationStarted($outcome));

            foreach ($this->evaluator->evaluate($outcome) as $status) {
                $this->dispatcher->dispatch(
                    $status->isSuccess() ? new Event\TestPassed($status) : new Event\TestFailed($status)
                );

                if ($stopOnFailure && !$status->isSuccess()) {
                    $this->dispatcher->dispatch(new Event\TestingAborted);
                    break 2;
                }
            }

            $this->dispatcher->dispatch(new Event\EvaluationDone($outcome));
        }
    }
}
