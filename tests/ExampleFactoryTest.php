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
            [
                'annotations' => [],
                'code' => ''
            ]
        ];

        $this->assertSame(
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

        $this->assertSame(
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

        $this->assertSame(
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

        $this->expectException('RuntimeException');
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

    function testAddEmptyExpectationToExamplesWithNoExpectations()
    {
        $defs = [
            [
                'annotations' => [],
                'code' => ''
            ]
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
            [
                'annotations' => [],
                'code' => "some lines\nof\ncode"
            ]
        ];

        $this->assertSame(
            "some lines\nof\ncode",
            $this->newFactory()->createExamples($defs)['1']->getCodeBlock()->getCode()
        );
    }

    function testExceptionIfExtendedExampleDoesNotExist()
    {
        $defs = [
            [
                'annotations' => [
                    ['extends', ['does-not-exist']]
                ],
                'code' => ""
            ]
        ];

        $this->expectException('RuntimeException');
        $this->newFactory()->createExamples($defs);
    }

    function testExtendExample()
    {
        $defs = [
            [
                'annotations' => [['example', ['parent']]],
                'code' => "echo 'parent';\n"
            ],
            [
                'annotations' => [
                    ['example', ['child']],
                    ['extends', ['parent']]
                ],
                'code' => "echo 'child';\n"
            ]
        ];

        $this->assertSame(
            "ob_start();\necho 'parent';\nob_end_clean();\necho 'child';\n",
            $this->newFactory()->createExamples($defs)['child']->getCodeBlock()->getCode()
        );
    }
}
