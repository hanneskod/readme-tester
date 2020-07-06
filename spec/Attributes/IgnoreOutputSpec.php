<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\IgnoreOutput;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\OutputExpectation;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IgnoreOutputSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IgnoreOutput::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms(ExampleInterface $example)
    {
        $example->withExpectation(new OutputExpectation(new Regexp('//')))->willReturn($example)->shouldBeCalled();
        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('\hanneskod\readmetester\Attributes\IgnoreOutput');
    }
}
