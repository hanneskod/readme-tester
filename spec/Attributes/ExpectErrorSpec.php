<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\ExpectError;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\ErrorExpectation;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExpectErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(ExpectError::class);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_transforms(ExampleObj $example)
    {
        $this->beConstructedWith('foo');

        $example->withExpectation(new ErrorExpectation(new Regexp('foo')))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('\hanneskod\readmetester\Attributes\ExpectError("foo")');
    }
}
