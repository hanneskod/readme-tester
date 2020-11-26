<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Input\Markdown;

use hanneskod\readmetester\Input\Markdown\MarkdownCompilerFactory;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkdownCompilerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MarkdownCompilerFactory::class);
    }

    function it_is_a_compiler_factory()
    {
        $this->shouldHaveType(CompilerFactoryInterface::class);
    }

    function it_creates_compilers()
    {
        $this->createCompiler()->shouldHaveType(CompilerInterface::class);
    }
}
