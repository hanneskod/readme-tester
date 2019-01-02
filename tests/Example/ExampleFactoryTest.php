<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\AnonymousName;
use hanneskod\readmetester\Name\ExampleName;
use hanneskod\readmetester\Parser\Annotation;
use hanneskod\readmetester\Parser\Definition;
use hanneskod\readmetester\Parser\CodeBlock;

/**
 * @covers \hanneskod\readmetester\ExampleFactory
 */
class ExampleFactoryTest extends \PHPUnit\Framework\TestCase
{
    function testAnonymousDefaultName()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''))
        );

        $this->assertEquals(new AnonymousName(''), $examples[0]->getName());
    }

    function testNameFromAnnotation()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('example', 'foobar'))
        );

        $this->assertEquals(new ExampleName('foobar', ''), $examples[0]->getName());
    }

    function testExceptionWhenNameIsNotUnique()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $this->expectException(\RuntimeException::CLASS);

        $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('example', 'name')),
            new Definition(new CodeBlock(''), new Annotation('example', 'name'))
        );
    }

    function testIgnoreExample()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('ignore'), new Annotation('example', 'name'))
        );

        $this->assertFalse($examples[0]->isActive());
    }

    function testCreateExpectationsFromAnnotations()
    {
        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();
        $expectationAnnotation = new Annotation('expectation', 'foo', 'bar');

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation($expectationAnnotation)->willReturn($expectation);

        $factory = new ExampleFactory($expectationFactory->reveal(), new ProcessorContainer);

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), $expectationAnnotation)
        );

        $this->assertEquals([$expectation], $examples[0]->getExpectations());
    }

    function testCreateSimpleCodeBlock()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $codeBlock = $this->prophesize(CodeBlock::CLASS)->reveal();

        $examples = $factory->createExamples(
            new Definition($codeBlock)
        );

        $this->assertSame($codeBlock, $examples[0]->getCodeBlock());
    }

    function testExceptionIfIncludedExampleDoesNotExist()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $this->expectException(\RuntimeException::CLASS);

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('include', 'does-not-exist'))
        );
    }

    function testIncludeExample()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $parentCode = $this->prophesize(CodeBlock::CLASS)->reveal();
        $childCode = $this->prophesize(CodeBlock::CLASS);

        $childCode->prepend($parentCode)->shouldBeCalled();

        $factory->createExamples(
            new Definition($parentCode, new Annotation('example', 'parent')),
            new Definition(
                $childCode->reveal(),
                new Annotation('example', 'child'),
                new Annotation('include', 'parent')
            )
        );
    }

    function testExampleContext()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $contextCode = $this->prophesize(CodeBlock::CLASS)->reveal();
        $exampleCode = $this->prophesize(CodeBlock::CLASS);

        $exampleCode->prepend($contextCode)->shouldBeCalled();

        $examples = $factory->createExamples(
            new Definition($contextCode, new Annotation('exampleContext')),
            new Definition($exampleCode->reveal())
        );
    }

    function testExceptionOnUnknownAnnotation()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer
        );

        $this->expectException(\RuntimeException::CLASS);

        $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('annotation-name-does-not-exist'))
        );
    }

    function testIgnoreUnknownAnnotation()
    {
        $factory = new ExampleFactory(
            $this->prophesize(ExpectationFactory::CLASS)->reveal(),
            new ProcessorContainer,
            true
        );

        $this->assertCount(
            1,
            $factory->createExamples(
                new Definition(new CodeBlock(''), new Annotation('annotation-name-does-not-exist'))
            )
        );
    }
}
