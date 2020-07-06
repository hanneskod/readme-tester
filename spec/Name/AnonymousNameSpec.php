<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\AnonymousName;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AnonymousNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AnonymousName::CLASS);
    }

    function it_is_a_name()
    {
        $this->shouldHaveType(NameInterface::CLASS);
    }

    function it_defaults_to_no_namespace()
    {
        $this->getNamespaceName()->shouldReturn('');
    }

    function it_contains_a_namespace()
    {
        $this->beConstructedWith('namespace');
        $this->getNamespaceName()->shouldReturn('namespace');
    }

    function it_contains_a_standard_short_name()
    {
        $this->getShortName()->shouldReturn('UNNAMED');
    }

    function it_contains_a_standard_complete_name()
    {
        $this->getCompleteName()->shouldReturn('UNNAMED');
    }

    function it_can_build_complete_name()
    {
        $this->beConstructedWith('namespace');
        $this->getCompleteName()->shouldReturn('namespace:UNNAMED');
    }

    function it_never_equals_a_name()
    {
        $this->equals($this)->shouldReturn(false);
    }

    function it_is_unnamed()
    {
        $this->shouldBeUnnamed();
    }
}
