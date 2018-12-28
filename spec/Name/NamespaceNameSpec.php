<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\NamespaceName;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NamespaceNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('namespace');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NamespaceName::CLASS);
    }

    function it_is_a_name()
    {
        $this->shouldHaveType(NameInterface::CLASS);
    }

    function it_contains_a_namespace()
    {
        $this->getNamespaceName()->shouldReturn('namespace');
    }

    function it_does_not_contain_a_short_name()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->during('getShortName');
    }

    function it_does_not_contain_a_complete_name()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->during('getName');
    }
}
