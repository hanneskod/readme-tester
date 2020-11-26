<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Input;

use hanneskod\readmetester\Input\ParsingCompiler;
use hanneskod\readmetester\Input\TemplateRenderer;
use hanneskod\readmetester\Input\Template;
use hanneskod\readmetester\Input\ParserInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParsingCompilerSpec extends ObjectBehavior
{
    function let(ParserInterface $parser, TemplateRenderer $renderer)
    {
        $this->beConstructedWith($parser, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ParsingCompiler::class);
    }

    function it_is_a_compiler()
    {
        $this->shouldHaveType(CompilerInterface::class);
    }

    function it_compiles(
        $parser,
        $renderer,
        InputInterface $inputA,
        InputInterface $inputB,
        Template $templateA,
        Template $templateB,
        ExampleStoreInterface $storeA,
        ExampleStoreInterface $storeB
    ) {
        $inputA->getContents()->willReturn('contentA');
        $inputA->getDefaultNamespace()->willReturn('namespaceA');
        $inputB->getContents()->willReturn('contentB');
        $inputB->getDefaultNamespace()->willReturn('namespaceB');

        $parser->parseContent('contentA')->willReturn($templateA);
        $parser->parseContent('contentB')->willReturn($templateB);

        $templateA->setDefaultNamespace('namespaceA')->shouldBeCalled();
        $templateB->setDefaultNamespace('namespaceB')->shouldBeCalled();

        $renderer->render($templateA)->willReturn($storeA);
        $renderer->render($templateB)->willReturn($storeB);

        $expected = new CombinedExampleStore;
        $expected->addExampleStore($storeA->getWrappedObject());
        $expected->addExampleStore($storeB->getWrappedObject());

        $this->compile([$inputA, $inputB])->shouldBeLike($expected);
    }
}
