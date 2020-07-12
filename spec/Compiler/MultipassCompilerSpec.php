<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\MultipassCompiler;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MultipassCompilerSpec extends ObjectBehavior
{
    function let(CompilerInterface $decoratedCompiler, CompilerPassInterface $compilerPass)
    {
        $this->beConstructedWith($decoratedCompiler, [$compilerPass]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MultipassCompiler::class);
    }

    function it_is_a_compiler()
    {
        $this->shouldHaveType(CompilerInterface::class);
    }

    function it_compiles($decoratedCompiler, $compilerPass, InputInterface $input, ExampleStoreInterface $store)
    {
        $decoratedCompiler->compile($input, $input)->willReturn($store)->shouldBeCalled();
        $compilerPass->process($store)->willReturn($store)->shouldBeCalled();
        $this->compile($input, $input)->shouldReturn($store);
    }
}
