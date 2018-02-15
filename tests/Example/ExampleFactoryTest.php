<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Parser\Annotation;
use hanneskod\readmetester\Parser\Definition;
use hanneskod\readmetester\Parser\CodeBlock;

/**
 * @covers \hanneskod\readmetester\ExampleFactory
 */
class ExampleFactoryTest extends \PHPUnit\Framework\TestCase
{
    function testIndexAsDefaultName()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''))
        );

        $this->assertSame('1', $examples['1']->getName());
    }

    function testNameFromAnnotation()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('example', 'foobar'))
        );

        $this->assertSame('foobar', $examples['foobar']->getName());
    }

    function testExceptionWhenNameIsNotUnique()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $this->expectException(\RuntimeException::CLASS);

        $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('example', 'name')),
            new Definition(new CodeBlock(''), new Annotation('example', 'name'))
        );
    }

    function testIgnoreExample()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('ignore'), new Annotation('example', 'name'))
        );

        $this->assertFalse($examples['name']->shouldBeEvaluated());
    }

    function testCreateExpectationsFromAnnotations()
    {
        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();
        $expectationAnnotation = new Annotation('expectation', 'foo', 'bar');

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation($expectationAnnotation)->willReturn($expectation);

        $factory = new ExampleFactory($expectationFactory->reveal());

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), $expectationAnnotation)
        );

        $this->assertEquals([$expectation], $examples['1']->getExpectations());
    }

    function testCreateSimpleCodeBlock()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());
        $codeBlock = $this->prophesize(CodeBlock::CLASS)->reveal();

        $examples = $factory->createExamples(
            new Definition($codeBlock)
        );

        $this->assertSame($codeBlock, $examples['1']->getCodeBlock());
    }

    function testExceptionIfIncludedExampleDoesNotExist()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $this->expectException(\RuntimeException::CLASS);

        $examples = $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('include', 'does-not-exist'))
        );
    }

    function testIncludeExample()
    {
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

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
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

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
        $factory = new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());

        $this->expectException(\RuntimeException::CLASS);

        $factory->createExamples(
            new Definition(new CodeBlock(''), new Annotation('annotation-name-does-not-exist'))
        );
    }
}
