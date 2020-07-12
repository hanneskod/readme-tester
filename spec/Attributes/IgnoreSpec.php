<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\Ignore;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IgnoreSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Ignore::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms(ExampleObj $example)
    {
        $example->withActive(false)->willReturn($example)->shouldBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('\hanneskod\readmetester\Attributes\Ignore');
    }
}
