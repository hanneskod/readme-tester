<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Expectation\StatusInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SuccessSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Success::CLASS);
    }

    function it_is_a_status()
    {
        $this->shouldHaveType(StatusInterface::CLASS);
    }

    function it_has_a_description()
    {
        $this->getDescription()->shouldReturn('foobar');
    }

    function it_is_a_success()
    {
        $this->shouldBeSuccess();
    }
}
