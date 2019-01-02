<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\ProcessorContainer;
use hanneskod\readmetester\Example\ProcessorInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessorContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProcessorContainer::CLASS);
    }

    function it_is_a_processor()
    {
        $this->shouldHaveType(ProcessorInterface::CLASS);
    }

    function it_calls_processors(ProcessorInterface $proccA, ProcessorInterface $proccB, ExampleInterface $example)
    {
        $this->beConstructedWith($proccA, $proccB);
        $proccA->process($example)->willReturn($example)->shouldBeCalled();
        $proccB->process($example)->willReturn($example)->shouldBeCalled();

        $this->process($example)->shouldReturn($example);
    }
}
