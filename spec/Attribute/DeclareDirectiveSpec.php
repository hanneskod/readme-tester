<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\DeclareDirective;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeclareDirectiveSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(DeclareDirective::class);
    }

    function it_is_an_attribute()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(AttributeInterface::class);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('#[\hanneskod\readmetester\Attribute\DeclareDirective("foo")]');
    }

    function it_can_get_as_attribute()
    {
        $this->beConstructedWith('foo');
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\DeclareDirective("foo")]');
    }

    function it_transforms_code(ExampleObj $example)
    {
        $this->beConstructedWith('foo');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $expected = new CodeBlock(
            "declare(foo);\t// #[\\hanneskod\\readmetester\\Attribute\\DeclareDirective(\"foo\")]\nbar"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }
}
