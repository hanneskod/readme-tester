<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\UseConst;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UseConstSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(UseConst::class);
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

        $example->withCodeBlock(new CodeBlock('use const foo;bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_adds_use_statement_with_as_postfix(ExampleObj $example)
    {
        $this->beConstructedWith('foo', 'baz');
        $example->getCodeBlock()->willReturn(new CodeBlock('bar'));

        $example->withCodeBlock(new CodeBlock('use const foo as baz;bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo', 'bar')->shouldReturn('\hanneskod\readmetester\Attributes\UseConst("foo", "bar")');
    }
}