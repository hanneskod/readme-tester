<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Attributes\Import;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(Import::CLASS);
    }

    function it_is_a_transformation()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(TransformationInterface::CLASS);
    }

    function it_transforms(ExampleObj $example, NameObj $name)
    {
        $this->beConstructedWith('foo');
        $example->getName()->willReturn($name);
        $name->getNamespaceName()->willReturn('bar');

        $example->withImport(NameObj::fromString('foo', 'bar'))->willReturn($example)->shouldBeCalled();

        $this->transform($example)->shouldReturn($example);
    }

    function it_can_create_attribute()
    {
        $this->beConstructedWith('');
        $this->createAttribute('foo')->shouldReturn('\hanneskod\readmetester\Attributes\Import("foo")');
    }
}
