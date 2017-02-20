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
            new Definition([], new CodeBlock(''))
        ];

        $this->assertSame(
            '1',
            $this->newFactory()->createExamples($defs)['1']->getName()
        );
    }

    function testNameFromAnnotation()
    {
        $defs = [
            new Definition([['example', ['foobar']]], new CodeBlock(''))
        ];

        $this->assertSame(
            'foobar',
            $this->newFactory()->createExamples($defs)['foobar']->getName()
        );
    }

    function testDefaultNameWhenAnnotationHasNoArgument()
    {
        $defs = [
            new Definition([['example', []]], new CodeBlock(''))
        ];

        $this->assertSame(
            '1',
            $this->newFactory()->createExamples($defs)['1']->getName()
        );
    }

    function testExceptionWhenNameIsNotUnique()
    {
        $defs = [
            new Definition([['example', ['name']]], new CodeBlock('')),
            new Definition([['example', ['name']]], new CodeBlock(''))
        ];

        $this->expectException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testIgnoreExample()
    {
        $defs = [
            new Definition([['ignore', []]], new CodeBlock(''))
        ];

        $this->assertEmpty(
            $this->newFactory()->createExamples($defs)
        );
    }

    function testCreateExpectationsFromAnnotations()
    {
        $defs = [
            new Definition([['expectation', ['foo', 'bar']]], new CodeBlock(''))
        ];

        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation('expectation', ['foo', 'bar'])->willReturn($expectation);

        $exampleFactory = new ExampleFactory($expectationFactory->reveal());

        $this->assertEquals(
            [$expectation],
            $exampleFactory->createExamples($defs)['1']->getExpectations()
        );
    }

    function testAddEmptyExpectationToExamplesWithNoExpectations()
    {
        $defs = [
            new Definition([], new CodeBlock(''))
        ];

        $expectation = $this->prophesize(ExpectationInterface::CLASS)->reveal();

        $expectationFactory = $this->prophesize(ExpectationFactory::CLASS);
        $expectationFactory->createExpectation('expectnothing', [])->willReturn($expectation);

        $exampleFactory = new ExampleFactory($expectationFactory->reveal());

        $this->assertEquals(
            [$expectation],
            $exampleFactory->createExamples($defs)['1']->getExpectations()
        );
    }

    function testCreateSimpleCodeBlock()
    {
        $defs = [
            new Definition([], new CodeBlock("some lines\nof\ncode"))
        ];

        $this->assertSame(
            "some lines\nof\ncode",
            $this->newFactory()->createExamples($defs)['1']->getCodeBlock()->getCode()
        );
    }

    function testExceptionIfExtendedExampleDoesNotExist()
    {
        $defs = [
            new Definition([['extends', ['does-not-exist']]], new CodeBlock(''))
        ];

        $this->expectException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testExtendExample()
    {
        $defs = [
            new Definition([['example', ['parent']]], new CodeBlock("echo 'parent';\n")),
            new Definition(
                [
                    ['example', ['child']],
                    ['extends', ['parent']]
                ],
                new CodeBlock("echo 'child';\n")
            )
        ];

        $this->assertSame(
            "ob_start();\necho 'parent';\nob_end_clean();\necho 'child';\n",
            $this->newFactory()->createExamples($defs)['child']->getCodeBlock()->getCode()
        );
    }

    function testExampleContext()
    {
        $defs = [
            new Definition([['exampleContext', []]], new CodeBlock("echo 'context';\n")),
            new Definition([], new CodeBlock("echo 'example';\n"))
        ];

        $this->assertSame(
            "ob_start();\necho 'context';\nob_end_clean();\necho 'example';\n",
            $this->newFactory()->createExamples($defs)['2']->getCodeBlock()->getCode()
        );
    }
}
