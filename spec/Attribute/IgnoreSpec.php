<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\Ignore;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IgnoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Ignore::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms(ExampleObj $example)
    {
        $example->withActive(false)->willReturn($example)->shouldBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\Ignore]');
    }

    function it_can_get_as_attribute()
    {
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\Ignore]');
    }
}
