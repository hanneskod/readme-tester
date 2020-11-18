<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\CompilerFactoryFactory;
use hanneskod\readmetester\Markdown;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerFactoryFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CompilerFactoryFactory::class);
    }

    function it_creates_markdown_factory()
    {
        $this->createCompilerFactory(CompilerFactoryFactory::INPUT_MARKDOWN)
            ->shouldHaveType(Markdown\CompilerFactory::class);
    }
}
