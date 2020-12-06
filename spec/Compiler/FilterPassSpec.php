<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\FilterPass;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\NameObj;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterPassSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Regexp(''));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterPass::class);
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_filters_on_name(ExampleObj $exampleA, ExampleObj $exampleB, ExampleStoreInterface $store)
    {
        $exampleA->getName()->willReturn(new NameObj('A', 'A'));
        $exampleB->getName()->willReturn(new NameObj('B', 'B'));

        $store->getExamples()->willReturn([$exampleA, $exampleB]);

        $this->beConstructedWith(new Regexp('/A/'));

        $this->process($store)->shouldBeLike(new ArrayExampleStore([$exampleA->getWrappedObject()]));
    }
}
