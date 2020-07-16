<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\Bootstrap;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BootstrapSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Bootstrap::class);
    }

    function it_is_a_transformation()
    {
        $this->shouldHaveType(TransformationInterface::class);
    }

    function it_bootstraps(ExampleObj $example)
    {
        $example->getCodeBlock()->willReturn(new CodeBlock("class YesItWorks {}"));

        $example->withActive(false)->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);

        // this will fail if code is not bootstraped
        new \YesItWorks;
    }

    function it_can_create_attribute()
    {
        $this->createAttribute()->shouldReturn('\hanneskod\readmetester\Attributes\Bootstrap');
    }
}
