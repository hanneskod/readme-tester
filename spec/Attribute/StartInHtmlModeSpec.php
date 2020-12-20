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

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\StartInHtmlMode]');
    }

    function it_can_get_as_attribute()
    {
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\StartInHtmlMode]');
    }

    function it_transforms_code(ExampleObj $example)
    {
        $example->getCodeBlock()->willReturn(new CodeBlock('foo'));

        $expected = new CodeBlock(
            "/*#[\\hanneskod\\readmetester\\Attribute\\StartInHtmlMode]*/ ?>\nfoo"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }
}
