<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Expectation\StatusInterface;
use hanneskod\readmetester\Runner\OutcomeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SuccessSpec extends ObjectBehavior
{
    function let(OutcomeInterface $outcome)
    {
        $this->beConstructedWith($outcome, 'foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Success::class);
    }

    function it_is_a_status()
    {
        $this->shouldHaveType(StatusInterface::class);
    }

    function it_contains_outcome($outcome)
    {
        $this->getOutcome()->shouldReturn($outcome);
    }

    function it_is_a_success()
    {
        $this->shouldBeSuccess();
    }

    function it_contains_content()
    {
        $this->getContent()->shouldReturn('foobar');
    }

    function it_can_truncated_content(OutcomeInterface $outcome)
    {
        $this->beConstructedWith($outcome, '12345678901234567890');
        $this->getTruncatedContent(10)->shouldReturn('1234567...');
    }

    function it_does_not_truncate_short_content(OutcomeInterface $outcome)
    {
        $this->beConstructedWith($outcome, '1234567890');
        $this->getTruncatedContent(10)->shouldReturn('1234567890');
    }

    function it_trims_truncated_content(OutcomeInterface $outcome)
    {
        $this->beConstructedWith($outcome, '   12345678901234567890   ');
        $this->getTruncatedContent(10)->shouldReturn('1234567...');
    }

    function it_trims_short_content_on_truncate(OutcomeInterface $outcome)
    {
        $this->beConstructedWith($outcome, '   1234567890   ');
        $this->getTruncatedContent(10)->shouldReturn('1234567890');
    }
}
