<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\InputLanguage;

use hanneskod\readmetester\InputLanguage\ParsingCompiler;
use hanneskod\readmetester\InputLanguage\ReflectiveExampleStoreTemplate;
use hanneskod\readmetester\InputLanguage\ParserInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Exception\InvalidInputException;
use hanneskod\readmetester\Exception\InvalidPhpCodeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParsingCompilerSpec extends ObjectBehavior
{
    function let(ParserInterface $parser)
    {
        $this->beConstructedWith($parser);
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
        InputInterface $inputA,
        InputInterface $inputB,
        ReflectiveExampleStoreTemplate $templateA,
        ReflectiveExampleStoreTemplate $templateB,
        ExampleStoreInterface $storeA,
        ExampleStoreInterface $storeB
    ) {
        $inputA->getContents()->willReturn('contentA');
        $inputA->getName()->willReturn('namespaceA');
        $inputB->getContents()->willReturn('contentB');
        $inputB->getName()->willReturn('namespaceB');

        $parser->parseContent('contentA')->willReturn($templateA);
        $parser->parseContent('contentB')->willReturn($templateB);

        $templateA->setDefaultNamespace('namespaceA')->shouldBeCalled();
        $templateB->setDefaultNamespace('namespaceB')->shouldBeCalled();

        $templateA->render()->willReturn($storeA);
        $templateB->render()->willReturn($storeB);

        $expected = new CombinedExampleStore;
        $expected->addExampleStore($storeA->getWrappedObject());
        $expected->addExampleStore($storeB->getWrappedObject());

        $this->compile([$inputA, $inputB])->shouldBeLike($expected);
    }

    function it_throws_on_invalid_php_code(
        $parser,
        InputInterface $input,
        ReflectiveExampleStoreTemplate $template,
    ) {
        $input->getContents()->willReturn('content');
        $input->getName()->willReturn('name');

        $parser->parseContent('content')->willReturn($template);

        $template->setDefaultNamespace('name')->shouldBeCalled();

        $template->render()->willThrow(new InvalidPhpCodeException('', ''));

        $this->shouldThrow(InvalidInputException::class)->duringCompile([$input]);
    }

    function it_throws_on_parser_exception($parser, InputInterface $input)
    {
        $input->getContents()->willReturn('content');

        $parser->parseContent('content')->willThrow(new \Exception);

        $this->shouldThrow(InvalidInputException::class)->duringCompile([$input]);
    }
}
