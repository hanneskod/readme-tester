<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Attribute\Assert;
use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssertSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Assert::class);
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

    function it_transforms_code(ExampleObj $example)
    {
        $this->beConstructedWith('$var');
        $example->getCodeBlock()->willReturn(new CodeBlock('foo'));

        $example->withCodeBlock(new CodeBlock("fooif (!\$var) trigger_error('Assertion failed', E_USER_ERROR);"))
            ->willReturn($example)
            ->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('#[\hanneskod\readmetester\Attribute\Assert("foo")]');
    }
}
