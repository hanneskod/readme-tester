<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\ListenerInterface;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleTesterSpec extends ObjectBehavior
{
    function it_tests_examples_and_fires_events(
        CodeBlock $codeBlock,
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        OutcomeInterface $outcome,
        RunnerInterface $runner,
        StatusInterface $status,
        ExpectationEvaluator $evaluator,
        ListenerInterface $listener
    ) {
        $example->getCodeBlock()->willReturn($codeBlock);
        $example->getExpectations()->willReturn(['list-of-expectations']);
        $example->isActive()->willReturn(true);

        $runner->run($codeBlock)->willReturn($outcome);

        $evaluator->evaluate(['list-of-expectations'], $outcome)->willReturn([$status]);

        $listener->onExample($example)->shouldBeCalled();
        $listener->onExpectation($status)->shouldBeCalled();

        $this->beConstructedWith($runner, $evaluator, false);

        $this->registerListener($listener);

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore);
    }

    function it_ignores_examples(
        ExampleStoreInterface $exampleStore,
        ExampleObj $example,
        RunnerInterface $runner,
        ExpectationEvaluator $evaluator,
        ListenerInterface $listener
    ) {
        $example->isActive()->willReturn(false);

        $listener->onIgnoredExample($example)->shouldBeCalled();

        $this->beConstructedWith($runner, $evaluator, false);

        $this->registerListener($listener);

        $exampleStore->getExamples()->willReturn([$example]);

        $this->test($exampleStore);
    }
}
