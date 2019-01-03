<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\ErrorOutcome;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorOutcomeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ErrorOutcome::CLASS);
    }

    function it_is_an_outcome()
    {
        $this->shouldHaveType(OutcomeInterface::CLASS);
    }

    function it_is_an_error_type()
    {
        $this->getType()->shouldReturn(OutcomeInterface::TYPE_ERROR);
    }

    function it_must_be_handled()
    {
        $this->mustBeHandled()->shouldReturn(true);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('foobar');
    }

    function it_contains_description()
    {
        $this->getDescription()->shouldMatch('/foobar/');
    }
}
