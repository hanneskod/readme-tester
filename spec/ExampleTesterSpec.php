<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\Event;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\SkippedOutcome;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\StatusInterface;
use hanneskod\readmetester\Utils\NameObj;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleTesterSpec extends ObjectBehavior
{
    function let(ExpectationEvaluator $evaluator, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($evaluator, $dispatcher);
    }

    function it_fires_on_test_passed(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $store,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
    ) {
        $example->getName()->willReturn(new NameObj('', ''));

        $outcome->getExample()->willReturn($example);

        $store->getExamples()->willReturn([$example]);

        $runner->run($store)->willReturn([$outcome]);

        $status->isSuccess()->willReturn(true);
        $status->getContent()->willReturn('');
        $status->getOutcome()->willReturn($outcome);

        $evaluator->evaluate($outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\EvaluationStarted::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestPassed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\EvaluationDone::class))->shouldBeCalled();

        $this->test($store, $runner, false);
    }

    function it_fires_on_test_failed(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $store,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
    ) {
        $example->getName()->willReturn(new NameObj('', ''));

        $outcome->getExample()->willReturn($example);

        $store->getExamples()->willReturn([$example]);

        $runner->run($store)->willReturn([$outcome]);

        $status->isSuccess()->willReturn(false);
        $status->getContent()->willReturn('');
        $status->getOutcome()->willReturn($outcome);

        $evaluator->evaluate($outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\EvaluationStarted::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestFailed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\EvaluationDone::class))->shouldBeCalled();

        $this->test($store, $runner, false);
    }

    function it_can_abort_after_failed_test(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $store,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
    ) {
        $example->getName()->willReturn(new NameObj('', ''));

        $outcome->getExample()->willReturn($example);

        $store->getExamples()->willReturn([$example]);

        $runner->run($store)->willReturn([$outcome]);

        $status->isSuccess()->willReturn(false);
        $status->getContent()->willReturn('');
        $status->getOutcome()->willReturn($outcome);

        $evaluator->evaluate($outcome)->willReturn([$status]);

        $dispatcher->dispatch(Argument::type(Event\EvaluationStarted::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestFailed::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\TestingAborted::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(Event\EvaluationDone::class))->shouldNotBeCalled();

        $this->test($store, $runner, true);
    }

    function it_ignores_skipped_examples(
        $evaluator,
        $dispatcher,
        ExampleStoreInterface $store,
        ExampleObj $example,
        RunnerInterface $runner,
    ) {
        $example->getName()->willReturn(new NameObj('', ''));

        $store->getExamples()->willReturn([$example]);

        $runner->run($store)->willReturn([new SkippedOutcome($example->getWrappedObject(), '')]);

        $dispatcher->dispatch(Argument::type(Event\EvaluationSkipped::class))->shouldBeCalled();

        $this->test($store, $runner, false);
    }
}
