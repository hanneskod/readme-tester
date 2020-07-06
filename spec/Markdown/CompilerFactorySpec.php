<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Markdown\CompilerFactory;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CompilerFactory::CLASS);
    }

    function it_is_a_compiler_factory()
    {
        $this->shouldHaveType(CompilerFactoryInterface::CLASS);
    }

    function it_creates_compilers()
    {
        $this->createCompiler()->shouldHaveType(CompilerInterface::class);
    }
}
