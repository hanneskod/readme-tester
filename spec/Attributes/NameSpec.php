<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\Name;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Name::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms_name(ExampleObj $example, NameObj $name)
    {
        $this->beConstructedWith('foo');
        $example->getName()->willReturn($name);
        $name->getNamespaceName()->willReturn('bar');

        $example->withName(NameObj::fromString('foo', 'bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute(' foo"bar ')->shouldReturn('\hanneskod\readmetester\Attributes\Name("foo\"bar")');
    }
}
