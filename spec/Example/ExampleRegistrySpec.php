<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Example;

use hanneskod\readmetester\Example\ExampleRegistry;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleRegistrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExampleRegistry::class);
    }

    function it_can_have_example(ExampleObj $example, NameObj $name)
    {
        $name->getFullName()->willReturn('foobar');
        $example->getName()->willReturn($name);
        $this->setExample($example);
        $this->hasExample($name)->shouldReturn(true);
    }

    function it_does_not_have_non_loaded_examples(NameObj $name)
    {
        $name->getFullName()->willReturn('foobar');
        $this->hasExample($name)->shouldReturn(false);
    }

    function it_throws_on_non_loaded_example(NameObj $name)
    {
        $name->getFullName()->willReturn('foobar');
        $name->getShortName()->willReturn('foobar');
        $this->shouldThrow(\RuntimeException::class)->during('getExample', [$name]);
    }

    function it_can_get_example(ExampleObj $example, NameObj $name)
    {
        $name->getFullName()->willReturn('foobar');
        $example->getName()->willReturn($name);
        $this->setExample($example);
        $this->getExample($name)->shouldReturn($example);
    }

    function it_can_get_loaded_examples(
        ExampleObj $exampleA,
        ExampleObj $exampleB,
        NameObj $nameA,
        NameObj $nameB
    ) {
        $nameA->getFullName()->willReturn('foo');
        $nameB->getFullName()->willReturn('bar');

        $exampleA->getName()->willReturn($nameA);
        $exampleB->getName()->willReturn($nameB);

        $this->setExample($exampleA);
        $this->setExample($exampleB);

        $this->getExamples()->shouldIterateAs([$exampleA, $exampleB]);
    }
}
