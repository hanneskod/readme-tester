<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\UseClass;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseClassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(UseClass::class);
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

    function it_adds_use_statement(ExampleObj $example)
    {
        $this->beConstructedWith('foo');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $example->withCodeBlock(new CodeBlock('use foo;bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_adds_use_statement_with_as_postfix(ExampleObj $example)
    {
        $this->beConstructedWith('foo', 'baz');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $example->withCodeBlock(new CodeBlock('use foo as baz;bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo', 'bar')
            ->shouldReturn('#[\hanneskod\readmetester\Attribute\UseClass("foo", "bar")]');
    }
}
