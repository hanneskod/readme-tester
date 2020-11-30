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
        foreach ($exampleStore->getExamples() as $example) {
            if (!$example->isActive()) {
                $this->dispatcher->dispatch(new Event\ExampleIgnored($example));
                continue;
            }

            $outcome = $runner->run($example);

            if ($outcome instanceof SkippedOutcome) {
                $this->dispatcher->dispatch(new Event\ExampleSkipped($example, $outcome));
                continue;
            }

            $this->dispatcher->dispatch(new Event\ExampleEntered($example));

            foreach ($this->evaluator->evaluate($example->getExpectations(), $outcome) as $status) {
                $event = $status->isSuccess()
                    ? new Event\TestPassed($example, $outcome, $status)
                    : new Event\TestFailed($example, $outcome, $status);

                $this->dispatcher->dispatch($event);

                if ($stopOnFailure && !$status->isSuccess()) {
                    $this->dispatcher->dispatch(new Event\TestingAborted);
                    break 2;
                }
            }

            $this->dispatcher->dispatch(new Event\ExampleExited($example));
        }
    }
}
