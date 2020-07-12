<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NameObjSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foo', 'bar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NameObj::CLASS);
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
        $this->getFullName()->shouldReturn('foo:bar');
    }

    function it_contains_a_complete_name_with_no_namespace()
    {
        $this->beConstructedWith('', 'bar');
        $this->getFullName()->shouldReturn('bar');
    }

    function it_sanitizes_names()
    {
        $this->beConstructedWith('clean, me', 'aåäö');
        $this->getFullName()->shouldReturn('clean-me:a');
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
