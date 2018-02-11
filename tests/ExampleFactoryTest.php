<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;

/**
 * @covers \hanneskod\readmetester\ExampleFactory
 */
class ExampleFactoryTest extends \PHPUnit\Framework\TestCase
{
    function newFactory()
    {
        return new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());
    }

    function testIndexAsDefaultName()
    {
        $defs = [
            new Definition(new CodeBlock(''))
        ];

        $this->assertSame(
            '1',
            $this->newFactory()->createExamples($defs)['1']->getName()
        );
    }

    function testNameFromAnnotation()
    {
        $defs = [
            new Definition(new CodeBlock(''), new Annotation('example', 'foobar'))
        ];

        $this->assertSame(
            'foobar',
            $this->newFactory()->createExamples($defs)['foobar']->getName()
        );
    }

    function testExceptionWhenNameIsNotUnique()
    {
        $defs = [
            new Definition(new CodeBlock(''), new Annotation('example', 'name')),
            new Definition(new CodeBlock(''), new Annotation('example', 'name'))
        ];

        $this->expectException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testIgnoreExample()
    {
        $defs = [
            new Definition(new CodeBlock(''), new Annotation('ignore'))
        ];

        $this->assertEmpty(
            $this->newFactory()->createExamples($defs)
        );
    }

    function testCreateExpectationsFromAnnotations()
    {
        $defs = [
            new Definition(new CodeBlock(''), new Annotation('expectation', 'foo', 'bar'))
        ];

        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation(new Annotation('expectation', 'foo', 'bar'))->willReturn($expectation);

        $exampleFactory = new ExampleFactory($expectationFactory->reveal());

        $this->assertEquals(
            [$expectation],
            $exampleFactory->createExamples($defs)['1']->getExpectations()
        );
    }

    function testAddEmptyExpectationToExamplesWithNoExpectations()
    {
        $defs = [
            new Definition(new CodeBlock(''))
        ];

        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation(new Annotation('expectNothing'))->willReturn($expectation);

        $exampleFactory = new ExampleFactory($expectationFactory->reveal());

        $this->assertEquals(
            [$expectation],
            $exampleFactory->createExamples($defs)['1']->getExpectations()
        );
    }

    function testCreateSimpleCodeBlock()
    {
        $this->assertSame(
            $codeBlock = $this->prophesize(CodeBlock::CLASS)->reveal(),
            $this->newFactory()->createExamples([new Definition($codeBlock)])['1']->getCodeBlock()
        );
    }

    function testExceptionIfExtendedExampleDoesNotExist()
    {
        $defs = [
            new Definition(new CodeBlock(''), new Annotation('extends', 'does-not-exist'))
        ];

        $this->expectException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testExtendExample()
    {
        $parentCode = $this->prophesize(CodeBlock::CLASS)->reveal();
        $childCode = $this->prophesize(CodeBlock::CLASS);

        $childCode->prepend($parentCode)->shouldBeCalled();

        $defs = [
            new Definition($parentCode, new Annotation('example', 'parent')),
            new Definition(
                $childCode->reveal(),
                new Annotation('example', 'child'),
                new Annotation('extends', 'parent')
            )
        ];

        $this->newFactory()->createExamples($defs);
    }

    function testExampleContext()
    {
        $contextCode = $this->prophesize(CodeBlock::CLASS)->reveal();
        $exampleCode = $this->prophesize(CodeBlock::CLASS);

        $exampleCode->prepend($contextCode)->shouldBeCalled();

        $defs = [
            new Definition($contextCode, new Annotation('exampleContext')),
            new Definition($exampleCode->reveal())
        ];

        $this->newFactory()->createExamples($defs);
    }
}
