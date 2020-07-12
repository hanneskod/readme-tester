<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\Failure;
use hanneskod\readmetester\Expectation\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FailureSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Failure::class);
    }

    function it_is_a_status()
    {
        $this->shouldHaveType(StatusInterface::class);
    }

    function it_has_a_description()
    {
        $this->getDescription()->shouldReturn('foobar');
    }

    function it_is_a_failure()
    {
        $this->shouldNotBeSuccess();
    }
}
