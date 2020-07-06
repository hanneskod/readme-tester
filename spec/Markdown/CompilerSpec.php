<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Markdown\Compiler;
use hanneskod\readmetester\Markdown\TemplateRenderer;
use hanneskod\readmetester\Markdown\Template;
use hanneskod\readmetester\Markdown\Parser;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerSpec extends ObjectBehavior
{
    function let(Parser $parser, TemplateRenderer $renderer)
    {
        $this->beConstructedWith($parser, $renderer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Compiler::CLASS);
    }

    function it_is_a_compiler()
    {
        $this->shouldHaveType(CompilerInterface::CLASS);
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

        $parser->parse('contentA')->willReturn($templateA);
        $parser->parse('contentB')->willReturn($templateB);

        $templateA->setDefaultNamespace('namespaceA')->shouldBeCalled();
        $templateB->setDefaultNamespace('namespaceB')->shouldBeCalled();

        $renderer->render($templateA)->willReturn($storeA);
        $renderer->render($templateB)->willReturn($storeB);

        $expected = new CombinedExampleStore;
        $expected->addExampleStore($storeA->getWrappedObject());
        $expected->addExampleStore($storeB->getWrappedObject());

        $this->compile($inputA, $inputB)->shouldBeLike($expected);
    }
}
