<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\DeclareStrictTypes;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeclareStrictTypesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeclareStrictTypes::class);
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
        $this->createAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\DeclareStrictTypes]');
    }

    function it_can_get_as_attribute()
    {
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\DeclareStrictTypes]');
    }

    function it_transforms_code(ExampleObj $example)
    {
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $expected = new CodeBlock(
            "declare(strict_types=1);\t// #[\\hanneskod\\readmetester\\Attribute\\DeclareStrictTypes]\nbar"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }
}
