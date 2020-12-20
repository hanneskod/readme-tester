<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\Example;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Example::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms_name(ExampleObj $example, NameObj $name)
    {
        $this->beConstructedWith('foo');
        $example->getName()->willReturn($name);
        $name->getNamespaceName()->willReturn('bar');

        $example->withName(NameObj::fromString('foo', 'bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_ignores_unknown_name(ExampleObj $example)
    {
        $example->withName(Argument::any())->shouldNotBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute('foo')->shouldReturn('#[\hanneskod\readmetester\Attribute\Example("foo")]');
    }

    function it_can_get_as_attribute()
    {
        $this->beConstructedWith('foo');
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\Example("foo")]');
    }
}
