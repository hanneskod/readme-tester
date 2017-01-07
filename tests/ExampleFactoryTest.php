<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;

/**
 * @covers \hanneskod\readmetester\ExampleFactory
 */
class ExampleFactoryTest extends \PHPUnit_Framework_TestCase
{
    function newFactory()
    {
        return new ExampleFactory($this->prophesize(ExpectationFactory::CLASS)->reveal());
    }

    function testIndexAsDefaultName()
    {
        $defs = [
            [
                'annotations' => [],
                'code' => ''
            ]
        ];

        $this->assertEquals(
            '1',
            $this->newFactory()->createExamples($defs)['1']->getName()
        );
    }

    function testNameFromAnnotation()
    {
        $defs = [
            [
                'annotations' => [
                    ['example', ['foobar']]
                ],
                'code' => ''
            ]
        ];

        $this->assertEquals(
            'foobar',
            $this->newFactory()->createExamples($defs)['foobar']->getName()
        );
    }

    function testDefaultNameWhenAnnotationHasNoArgument()
    {
        $defs = [
            [
                'annotations' => [
                    ['example', []]
                ],
                'code' => ''
            ]
        ];

        $this->assertEquals(
            '1',
            $this->newFactory()->createExamples($defs)['1']->getName()
        );
    }

    function testExceptionWhenNameIsNotUnique()
    {
        $defs = [
            [
                'annotations' => [
                    ['example', ['name']]
                ],
                'code' => ''
            ],
            [
                'annotations' => [
                    ['example', ['name']]
                ],
                'code' => ''
            ]
        ];

        $this->setExpectedException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testIgnoreExample()
    {
        $defs = [
            [
                'annotations' => [
                    ['ignore', []]
                ],
                'code' => ''
            ]
        ];

        $this->assertEmpty(
            $this->newFactory()->createExamples($defs)
        );
    }

    function testCreateSimpleCodeBlock()
    {
        $defs = [
            [
                'annotations' => [],
                'code' => "some lines\nof\ncode"
            ]
        ];

        $this->assertEquals(
            new CodeBlock("some lines\nof\ncode"),
            $this->newFactory()->createExamples($defs)['1']->getCode()
        );
    }

    function testCreateExpectationsFromAnnotations()
    {
        $defs = [
            [
                'annotations' => [
                    ['expectation', ['foo', 'bar']]
                ],
                'code' => ''
            ]
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
}
