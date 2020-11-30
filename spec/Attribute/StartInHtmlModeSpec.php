<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\StartInHtmlMode;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StartInHtmlModeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StartInHtmlMode::class);
    }

    function it_is_an_attribute()
    {
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms_code(ExampleObj $example)
    {
        $example->getCodeBlock()->willReturn(new CodeBlock('foo'));

        $example->withCodeBlock(new CodeBlock('?>foo'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute('foo')->shouldReturn('#[\hanneskod\readmetester\Attribute\StartInHtmlMode("foo")]');
    }
}
