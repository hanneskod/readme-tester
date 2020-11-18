<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\Instantiator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstantiatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Instantiator::class);
    }

    function it_instantiates()
    {
        $this->instantiate(Instantiator::class)->shouldHaveType(Instantiator::class);
    }

    function it_throws_if_class_does_not_exist()
    {
        $this->shouldThrow(\RuntimeException::class)->duringInstantiate('this-class-does-not-exist');
    }

    function it_throws_if_class_can_not_be_instantiated_without_arguments()
    {
        $this->shouldThrow(\RuntimeException::class)->duringInstantiate(ConstructorArgsRequired::class);
    }

    function it_throws_on_abstract_class()
    {
        $this->shouldThrow(\RuntimeException::class)->duringInstantiate(NotInstantiable::class);
    }
}
