<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\UniqueNamePass;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UniqueNamePassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UniqueNamePass::CLASS);
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType(CompilerPassInterface::CLASS);
    }

    function it_ignores_non_duplicates(ExampleStoreInterface $store, ExampleInterface $example, Name $name)
    {
        $store->getExamples()->willReturn([$example]);
        $example->getName()->willReturn($name);
        $name->getFullName()->willReturn('foobar');
        $this->process($store)->shouldReturn($store);
    }

    function it_throws_on_duplicates(ExampleStoreInterface $store, ExampleInterface $example, Name $name)
    {
        $store->getExamples()->willReturn([$example, $example]);
        $example->getName()->willReturn($name);
        $name->getFullName()->willReturn('foobar');
        $this->shouldThrow(\RuntimeException::class)->duringProcess($store);
    }
}
