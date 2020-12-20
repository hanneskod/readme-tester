<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\ErrorExpectation;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Expectation\Failure;
use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Runner\OutcomeInterface;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorExpectationSpec extends ObjectBehavior
{
    function let(Regexp $regexp)
    {
        $this->beConstructedWith($regexp);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ErrorExpectation::class);
    }

    function it_is_an_expectation()
    {
        $this->shouldHaveType(ExpectationInterface::class);
    }

    function it_can_be_converted_to_string($regexp)
    {
        $regexp->getRegexp()->willReturn('foobar')->shouldBeCalled();
        $this->getDescription();
    }

    function it_handles_errors(OutcomeInterface $outcome)
    {
        $outcome->isError()->willReturn(true);
        $this->handles($outcome)->shouldReturn(true);
    }

    function it_does_not_handle_other_outcomes(OutcomeInterface $outcome)
    {
        $outcome->isError()->willReturn(false);
        $this->handles($outcome)->shouldReturn(false);
    }

    function it_returns_failure_on_no_match($regexp, OutcomeInterface $outcome)
    {
        $outcome->getContent()->willReturn('foobar');
        $regexp->matches('foobar')->willReturn(false);
        $regexp->getRegexp()->willReturn('');
        $this->handle($outcome)->shouldHaveType(Failure::class);
    }

    function it_returns_success_on_match($regexp, OutcomeInterface $outcome)
    {
        $outcome->getContent()->willReturn('foobar');
        $regexp->matches('foobar')->willReturn(true);
        $regexp->getRegexp()->willReturn('');
        $this->handle($outcome)->shouldHaveType(Success::class);
    }
}
