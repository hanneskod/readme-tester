<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\AppendCode;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AppendCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(AppendCode::class);
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
        $this->createAttribute('foo')->shouldReturn('#[\hanneskod\readmetester\Attribute\AppendCode("foo")]');
    }

    function it_can_get_as_attribute()
    {
        $this->beConstructedWith('foo');
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\AppendCode("foo")]');
    }

    function it_transforms_code(ExampleObj $example)
    {
        $this->beConstructedWith('foo');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar::'));

        $expected = new CodeBlock(
            "bar::foo\t// #[\\hanneskod\\readmetester\\Attribute\\AppendCode(\"foo\")]\n"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }
}
