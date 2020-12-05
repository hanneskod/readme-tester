<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\VoidExpectation;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Expectation\Failure;
use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoidExpectationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VoidExpectation::class);
    }

    function it_is_an_expectation()
    {
        $this->shouldHaveType(ExpectationInterface::class);
    }

    function it_handles_all_outcomes(OutcomeInterface $outcome)
    {
        $this->handles($outcome)->shouldReturn(true);
    }

    function it_returns_failure_on_output(OutcomeInterface $outcome)
    {
        $outcome->isError()->willReturn(false);
        $outcome->isOutput()->willReturn(true);
        $outcome->getContent()->willReturn('');
        $this->handle($outcome)->shouldHaveType(Failure::class);
    }

    function it_returns_failure_on_error(OutcomeInterface $outcome)
    {
        $outcome->isError()->willReturn(true);
        $outcome->isOutput()->willReturn(false);
        $outcome->getContent()->willReturn('');
        $this->handle($outcome)->shouldHaveType(Failure::class);
    }

    function it_returns_success_on_other_outcomes(OutcomeInterface $outcome)
    {
        $outcome->isError()->willReturn(false);
        $outcome->isOutput()->willReturn(false);
        $this->handle($outcome)->shouldHaveType(Success::class);
    }
}
