<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Name;

use hanneskod\readmetester\Name\NamespacedName;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NamespacedNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', 'bar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NamespacedName::CLASS);
    }

    function it_is_a_name()
    {
        $this->shouldHaveType(NameInterface::CLASS);
    }

    function it_contains_a_namespace()
    {
        $this->getNamespaceName()->shouldReturn('foo');
    }

    function it_contains_a_short_name()
    {
        $this->getShortName()->shouldReturn('bar');
    }

    function it_contains_a_complete_name()
    {
        $this->getCompleteName()->shouldReturn('foo:bar');
    }

    function it_contains_a_complete_name_with_no_namespace()
    {
        $this->beConstructedWith('', 'bar');
        $this->getCompleteName()->shouldReturn('bar');
    }

    function it_sanitizes_names()
    {
        $this->beConstructedWith('clean, me', 'aåäö');
        $this->getCompleteName()->shouldReturn('clean-me:a');
    }

    function it_does_not_equal_wrong_name(NameInterface $name)
    {
        $name->getCompleteName()->willReturn('baz');
        $this->equals($name)->shouldReturn(false);
    }

    function it_equals_correct_name(NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foo:bar');
        $this->equals($name)->shouldReturn(true);
    }

    function it_is_not_unnamed()
    {
        $this->shouldNotBeUnnamed();
    }

    function it_creates_from_string()
    {
        $this->beConstructedThrough('fromString', ['foo:bar']);
        $this->getNamespaceName()->shouldReturn('foo');
        $this->getShortName()->shouldReturn('bar');
    }

    function it_creates_from_empty_string()
    {
        $this->beConstructedThrough('fromString', ['']);
        $this->getNamespaceName()->shouldReturn('');
        $this->getShortName()->shouldReturn('');
    }

    function it_creates_using_default_namespace()
    {
        $this->beConstructedThrough('fromString', ['', 'foo']);
        $this->getNamespaceName()->shouldReturn('foo');
        $this->getShortName()->shouldReturn('');
    }

    function it_ignores_default_namespace_if_specified()
    {
        $this->beConstructedThrough('fromString', ['foo:bar', 'baz']);
        $this->getNamespaceName()->shouldReturn('foo');
        $this->getShortName()->shouldReturn('bar');
    }

    function it_creates_from_short_name()
    {
        $this->beConstructedThrough('fromString', ['foo']);
        $this->getNamespaceName()->shouldReturn('');
        $this->getShortName()->shouldReturn('foo');
    }

    function it_creates_from_short_name_with_namespace_prefix()
    {
        $this->beConstructedThrough('fromString', [':foo']);
        $this->getNamespaceName()->shouldReturn('');
        $this->getShortName()->shouldReturn('foo');
    }

    function it_uses_default_namespace_with_short_name()
    {
        $this->beConstructedThrough('fromString', ['foo', 'bar']);
        $this->getNamespaceName()->shouldReturn('bar');
        $this->getShortName()->shouldReturn('foo');
    }
}
