<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\NamespaceName;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Utils\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NamespaceNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(NamespaceName::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms_namespace_name(ExampleInterface $example, Name $name)
    {
        $this->beConstructedWith('foo');
        $example->getName()->willReturn($name);
        $name->getShortName()->willReturn('bar');

        $example->withName(new Name('foo', 'bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('\hanneskod\readmetester\Attributes\NamespaceName("foo")');
    }
}
