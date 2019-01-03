<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\ExampleRegistry;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Example\RegistryInterface;
use hanneskod\readmetester\Name\NameInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExampleRegistry::CLASS);
    }

    function it_is_a_registry()
    {
        $this->shouldHaveType(RegistryInterface::CLASS);
    }

    function it_can_have_example(ExampleInterface $example, NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foobar');
        $name->isUnnamed()->willReturn(false);
        $example->getName()->willReturn($name);
        $this->setExample($example);
        $this->hasExample($name)->shouldReturn(true);
    }

    function it_does_not_have_non_loaded_examples(NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foobar');
        $name->isUnnamed()->willReturn(false);
        $this->hasExample($name)->shouldReturn(false);
    }

    function it_does_not_have_unnamed_examples(ExampleInterface $example, NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foobar');
        $name->isUnnamed()->willReturn(true);
        $example->getName()->willReturn($name);
        $this->setExample($example);
        $this->hasExample($name)->shouldReturn(false);
    }

    function it_throws_on_non_loaded_example(NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foobar');
        $this->shouldThrow(\RuntimeException::CLASS)->during('getExample', [$name]);
    }

    function it_can_get_example(ExampleInterface $example, NameInterface $name)
    {
        $name->getCompleteName()->willReturn('foobar');
        $name->isUnnamed()->willReturn(false);
        $example->getName()->willReturn($name);
        $this->setExample($example);
        $this->getExample($name)->shouldReturn($example);
    }

    function it_can_get_loaded_examples(
        ExampleInterface $unnamedEx,
        ExampleInterface $namedEx,
        NameInterface $unnamed,
        NameInterface $named
    ) {
        $unnamed->getCompleteName()->willReturn('foo');
        $unnamed->isUnnamed()->willReturn(true);
        $named->getCompleteName()->willReturn('bar');
        $named->isUnnamed()->willReturn(false);

        $unnamedEx->getName()->willReturn($unnamed);
        $namedEx->getName()->willReturn($named);

        $this->setExample($unnamedEx);
        $this->setExample($namedEx);

        $this->getExamples()->shouldIterateAs([$unnamedEx, $namedEx]);
    }
}
