<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\IgnoreUnmarkedExamples;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Attribute\Example;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IgnoreUnmarkedExamplesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IgnoreUnmarkedExamples::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_ignores_unmaked_example(ExampleObj $example)
    {
        $example->getAttributes()->willReturn([(object)array()]);
        $example->withActive(false)->willReturn($example)->shouldBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_skipps_marked_example(ExampleObj $example)
    {
        $example->getAttributes()->willReturn([new Example]);
        $example->withActive(false)->shouldNotBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\IgnoreUnmarkedExamples]');
    }
}
