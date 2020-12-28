<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Compiler\CompilerFactoryFactory;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Exception\InstantiatorException;
use hanneskod\readmetester\Exception\InvalidInputLanguageException;
use hanneskod\readmetester\InputLanguage\Markdown\MarkdownCompilerFactory;
use hanneskod\readmetester\Utils\Instantiator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerFactoryFactorySpec extends ObjectBehavior
{
    function let(Instantiator $instantiator)
    {
        $this->beConstructedWith($instantiator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CompilerFactoryFactory::class);
    }

    function it_creates_markdown_factory($instantiator, CompilerFactoryInterface $factory)
    {
        $instantiator->getNewObject(MarkdownCompilerFactory::class)
            ->willReturn($factory)
            ->shouldBeCalled();

        $this->createCompilerFactory(Configs::INPUT_ID_MARKDOWN)
            ->shouldReturn($factory);
    }

    function it_creates_from_classname($instantiator, CompilerFactoryInterface $factory)
    {
        $instantiator->getNewObject('compiler-factory-classname')
            ->willReturn($factory)
            ->shouldBeCalled();

        $this->createCompilerFactory('compiler-factory-classname')
            ->shouldReturn($factory);
    }

    function it_throws_on_invalid_id($instantiator)
    {
        $instantiator->getNewObject('does-not-exist')
            ->willThrow(new InstantiatorException())
            ->shouldBeCalled();

        $this->shouldThrow(InvalidInputLanguageException::class)
            ->duringCreateCompilerFactory('does-not-exist');
    }

    function it_throws_on_invalid_class($instantiator)
    {
        $instantiator->getNewObject('not-a-compiler-factory-classname')
            ->willReturn((object)[])
            ->shouldBeCalled();

        $this->shouldThrow(InvalidInputLanguageException::class)
            ->duringCreateCompilerFactory('not-a-compiler-factory-classname');
    }
}
