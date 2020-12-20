<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\UseFunction;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseFunctionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(UseFunction::class);
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
        $this->createAttribute('foo', 'bar')
            ->shouldReturn('#[\hanneskod\readmetester\Attribute\UseFunction("foo", "bar")]');
    }

    function it_can_get_as_attribute()
    {
        $this->beConstructedWith('foo');
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\UseFunction("foo")]');
    }

    function it_can_get_as_attribute_with_postfix()
    {
        $this->beConstructedWith('foo', 'bar');
        $this->asAttribute()->shouldReturn('#[\hanneskod\readmetester\Attribute\UseFunction("foo", "bar")]');
    }

    function it_adds_use_statement(ExampleObj $example)
    {
        $this->beConstructedWith('foo');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $expected = new CodeBlock(
            "use function foo;\t// #[\\hanneskod\\readmetester\\Attribute\\UseFunction(\"foo\")]\nbar"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_adds_use_statement_with_as_postfix(ExampleObj $example)
    {
        $this->beConstructedWith('foo', 'baz');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $expected = new CodeBlock(
            "use function foo as baz;\t// #[\\hanneskod\\readmetester\\Attribute\\UseFunction(\"foo\", \"baz\")]\nbar"
        );

        $example->withCodeBlock($expected)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }
}
