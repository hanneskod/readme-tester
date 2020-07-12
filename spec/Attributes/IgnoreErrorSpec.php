<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\IgnoreError;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\ErrorExpectation;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IgnoreErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IgnoreError::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms(ExampleObj $example)
    {
        $example->withExpectation(new ErrorExpectation(new Regexp('//')))->willReturn($example)->shouldBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('\hanneskod\readmetester\Attributes\IgnoreError');
    }
}
