<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\SkippedOutcome;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SkippedOutcomeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkippedOutcome::class);
    }

    function it_is_an_outcome()
    {
        $this->shouldHaveType(OutcomeInterface::class);
    }

    function it_is_a_void_type()
    {
        $this->getType()->shouldReturn(OutcomeInterface::TYPE_SKIPPED);
    }

    function it_must_not_be_handled()
    {
        $this->mustBeHandled()->shouldReturn(false);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('');
    }

    function it_can_truncated_content()
    {
        $this->getTruncatedContent()->shouldReturn('');
    }

    function it_contains_description()
    {
        $this->beConstructedWith('desc');
        $this->getDescription()->shouldReturn('desc');
    }
}
