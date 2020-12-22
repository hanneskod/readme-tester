<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Utils;

use hanneskod\readmetester\Utils\Instantiator;
use hanneskod\readmetester\Exception\InstantiatorException;
use Psr\Container\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstantiatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Instantiator::class);
    }

    function it_creates_new_objects()
    {
        $this->getNewObject(Instantiator::class)->shouldHaveType(Instantiator::class);
    }

    function it_throws_if_class_does_not_exist()
    {
        $this->shouldThrow(InstantiatorException::class)->duringGetNewObject('this-class-does-not-exist');
    }

    function it_throws_if_class_can_not_be_instantiated_without_arguments()
    {
        $this->shouldThrow(InstantiatorException::class)->duringGetNewObject(ConstructorArgsRequired::class);
    }

    function it_creates_from_class_with_optional_constructor_arguments()
    {
        $this->getNewObject(ConstructorArgsOptional::class)->shouldHaveType(ConstructorArgsOptional::class);
    }

    function it_throws_on_abstract_class()
    {
        $this->shouldThrow(InstantiatorException::class)->duringGetNewObject(NotInstantiable::class);
    }

    function it_creates_shared_objects()
    {
        $this->getSharedObject(Instantiator::class)->shouldReturn(
            $this->getSharedObject(Instantiator::class)
        );
    }

    function it_implements_container_interface()
    {
        $this->shouldHaveType(ContainerInterface::class);

        $this->has(Instantiator::class)->shouldReturn(false);

        $this->get(Instantiator::class)->shouldHaveType(Instantiator::class);

        $this->has(Instantiator::class)->shouldReturn(true);
    }
}

// phpcs:disable

class ConstructorArgsRequired
{
    public function __construct($anArgument)
    {
    }
}

class ConstructorArgsOptional
{
    public function __construct($anArgument = null)
    {
    }
}

abstract class NotInstantiable
{
}
