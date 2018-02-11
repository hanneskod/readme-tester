<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Parser\Annotation;

/**
 * @covers \hanneskod\readmetester\Expectation\ExpectationFactory
 */
class ExpectationFactoryTest extends \PHPUnit\Framework\TestCase
{
    function testCreateNothing()
    {
        $this->assertNull(
            (new ExpectationFactory)->createExpectation(new Annotation('foo'))
        );
    }

    function testCreateExceptionExpectation()
    {
        $this->assertEquals(
            new ExceptionExpectation('arg'),
            (new ExpectationFactory)->createExpectation(new Annotation('expectException', 'arg'))
        );
    }

    function testCreateOutputExpectation()
    {
        $this->assertEquals(
            new OutputExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectOutput', 'arg'))
        );
    }

    function testCreateReturnTypeExpectation()
    {
        $this->assertEquals(
            new ReturnTypeExpectation('arg'),
            (new ExpectationFactory)->createExpectation(new Annotation('expectReturnType', 'arg'))
        );
    }

    function testCreateReturnExpectation()
    {
        $this->assertEquals(
            new ReturnExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectReturn', 'arg'))
        );
    }

    function testCreateEmptyExpectation()
    {
        $this->assertEquals(
            new NullExpectation,
            (new ExpectationFactory)->createExpectation(new Annotation('expectNothing'))
        );
    }
}
