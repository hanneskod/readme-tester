<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegexpSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Regexp::CLASS);
    }

    function it_can_match()
    {
        $this->beConstructedWith('/test/');
        $this->matches('this test should match')->shouldReturn(true);
    }

    function it_can_fail_match()
    {
        $this->beConstructedWith('foo');
        $this->matches('bar')->shouldReturn(false);
    }

    function it_can_match_with_custom_delimiter()
    {
        $this->beConstructedWith('#delimiter#');
        $this->matches('a different delimiter')->shouldReturn(true);
    }

    function it_can_make_regexp()
    {
        $this->beConstructedWith('test');
        $this->matches('test')->shouldReturn(true);
    }

    function it_can_return_internal_regexp()
    {
        $this->beConstructedWith('foo');
        $this->getRegexp()->shouldReturn('/^foo$/');
    }
}
