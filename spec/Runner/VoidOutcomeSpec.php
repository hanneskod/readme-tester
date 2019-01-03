<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\VoidOutcome;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoidOutcomeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VoidOutcome::CLASS);
    }

    function it_is_an_outcome()
    {
        $this->shouldHaveType(OutcomeInterface::CLASS);
    }

    function it_is_a_void_type()
    {
        $this->getType()->shouldReturn(OutcomeInterface::TYPE_VOID);
    }

    function it_must_not_be_handled()
    {
        $this->mustBeHandled()->shouldReturn(false);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('');
    }

    function it_contains_description()
    {
        $this->getDescription()->shouldMatch('/./');
    }
}
