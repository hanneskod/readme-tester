<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\ExpectationEvaluator;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Expectation\Failure;
use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExpectationEvaluatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExpectationEvaluator::class);
    }

    function it_triggers_failure_on_unhandled_outcome(OutcomeInterface $outcome, ExampleObj $example)
    {
        $outcome->mustBeHandled()->willReturn(true);
        $outcome->getDescription()->willReturn('');
        $outcome->getExample()->willReturn($example);
        $example->getExpectations()->willReturn([]);
        $this->evaluate($outcome)->shouldReturnStatus([Failure::class]);
    }

    function it_ignores_outcomes_that_does_not_need_to_be_handled(OutcomeInterface $outcome, ExampleObj $example)
    {
        $outcome->mustBeHandled()->willReturn(false);
        $outcome->getExample()->willReturn($example);
        $example->getExpectations()->willReturn([]);
        $this->evaluate($outcome)->shouldReturn([]);
    }

    function it_failes_if_handling_expectation_failes(
        OutcomeInterface $outcome,
        ExampleObj $example,
        ExpectationInterface $expectation
    ) {
        $outcome->mustBeHandled()->willReturn(false);

        $outcome->getExample()->willReturn($example);
        $example->getExpectations()->willReturn([$expectation]);

        $expectation->getDescription()->willReturn('');
        $expectation->handles($outcome)->willReturn(false);

        $this->evaluate($outcome)->shouldReturnStatus([Failure::class]);
    }

    function it_handles(
        OutcomeInterface $outcome,
        ExampleObj $example,
        ExpectationInterface $exptA,
        ExpectationInterface $exptB
    ) {
        $outcome->mustBeHandled()->willReturn(true);
        $outcome->getDescription()->willReturn('');

        $outcome->getExample()->willReturn($example);
        $example->getExpectations()->willReturn([$exptA, $exptB]);

        $exptA->getDescription()->willReturn('');
        $exptA->handles($outcome)->willReturn(false);
        $exptB->getDescription()->willReturn('');
        $exptB->handles($outcome)->willReturn(true);
        $exptB->handle($outcome)->willReturn(new Success($outcome->getWrappedObject(), ''));

        $this->evaluate($outcome)->shouldReturnStatus([Failure::class, Success::class]);
    }

    function getMatchers(): array
    {
        return [
            'returnStatus' => function ($status, $expected) {
                foreach ($expected as $key => $classname) {
                    if (!$status[$key] instanceof $classname) {
                        return false;
                    }
                }

                return true;
            },
        ];
    }
}
