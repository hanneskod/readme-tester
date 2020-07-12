<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\NamespaceName;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NamespaceNameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(NamespaceName::class);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms_namespace_name(ExampleObj $example, NameObj $name)
    {
        $this->beConstructedWith('foo');
        $example->getName()->willReturn($name);
        $name->getShortName()->willReturn('bar');

        $example->withName(new NameObj('foo', 'bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('\hanneskod\readmetester\Attributes\NamespaceName("foo")');
    }
}
