<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\FilterUnnamedProcessor;
use hanneskod\readmetester\Example\ProcessorInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterUnnamedProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilterUnnamedProcessor::CLASS);
    }

    function it_is_a_processor()
    {
        $this->shouldHaveType(ProcessorInterface::CLASS);
    }

    function it_filters_on_unnamed(ExampleInterface $example, NameInterface $name)
    {
        $example->getName()->willReturn($name);
        $name->isUnnamed()->willReturn(true);

        $example->withActive(false)->willReturn($example)->shouldBeCalled();
        $this->process($example)->shouldReturn($example);
    }

    function it_ignores_not_unnamed(ExampleInterface $example, NameInterface $name)
    {
        $example->getName()->willReturn($name);
        $name->isUnnamed()->willReturn(false);

        $this->process($example)->shouldReturn($example);
    }
}
