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
        $defs = [
            new Definition(new CodeBlock("some lines\nof\ncode"))
        ];

        $this->assertSame(
            "some lines\nof\ncode",
            $this->newFactory()->createExamples($defs)['1']->getCodeBlock()->getCode()
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
        $defs = [
            new Definition(new CodeBlock("echo 'parent';\n"), new Annotation('example', 'parent')),
            new Definition(
                new CodeBlock("echo 'child';\n"),
                new Annotation('example', 'child'),
                new Annotation('extends', 'parent')
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
            new Definition(new CodeBlock("echo 'context';\n"), new Annotation('exampleContext')),
            new Definition(new CodeBlock("echo 'example';\n"))
        ];

        $this->assertSame(
            "ob_start();\necho 'context';\nob_end_clean();\necho 'example';\n",
            $this->newFactory()->createExamples($defs)['2']->getCodeBlock()->getCode()
        );
    }
}
