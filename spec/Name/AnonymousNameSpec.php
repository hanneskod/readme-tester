<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\AnonymousName;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AnonymousNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('namespace');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnonymousName::CLASS);
    }

    function it_is_a_name()
    {
        $this->shouldHaveType(NameInterface::CLASS);
    }

    function it_contains_a_namespace()
    {
        $this->getNamespaceName()->shouldReturn('namespace');
    }

    function it_contains_a_standard_short_name()
    {
        $this->getShortName()->shouldReturn('UNNAMED');
    }

    function it_contains_a_standard_complete_name()
    {
        $this->getCompleteName()->shouldReturn('namespace:UNNAMED');
    }

    function it_never_equals_a_name(NameInterface $name)
    {
        $this->equals($name)->shouldReturn(false);
    }
}
