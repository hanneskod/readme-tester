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
        $this->shouldHaveType(ErrorOutcome::class);
    }

    function it_is_an_outcome()
    {
        $this->shouldHaveType(OutcomeInterface::class);
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

    function it_can_truncated_content()
    {
        $this->beConstructedWith('12345678901234567890');
        $this->getTruncatedContent(10)->shouldReturn('1234567...');
    }

    function it_does_not_truncate_short_content()
    {
        $this->beConstructedWith('1234567890');
        $this->getTruncatedContent(10)->shouldReturn('1234567890');
    }

    function it_trims_truncated_content()
    {
        $this->beConstructedWith('   12345678901234567890   ');
        $this->getTruncatedContent(10)->shouldReturn('1234567...');
    }

    function it_trims_short_content_on_truncate()
    {
        $this->beConstructedWith('   1234567890   ');
        $this->getTruncatedContent(10)->shouldReturn('1234567890');
    }

    function it_contains_description()
    {
        $this->getDescription()->shouldMatch('/foobar/');
    }
}
