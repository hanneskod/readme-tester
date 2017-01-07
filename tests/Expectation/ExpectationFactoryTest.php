<?php

namespace hanneskod\readmetester\Expectation;

/**
 * @covers \hanneskod\readmetester\Expectation\ExpectationFactory
 */
class ExpectationFactoryTest extends \PHPUnit_Framework_TestCase
{
    function testCreateNothing()
    {
        $this->assertNull(
            (new ExpectationFactory)->createExpectation('foo', [])
        );
    }

    function testCreateExceptionExpectation()
    {
        $this->assertEquals(
            new ExceptionExpectation('arg'),
            (new ExpectationFactory)->createExpectation('expectException', ['arg'])
        );
    }

    function testCreateOutputExpectation()
    {
        $this->assertEquals(
            new OutputExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation('expectOutput', ['arg'])
        );
    }

    function testCreateReturnTypeExpectation()
    {
        $this->assertEquals(
            new ReturnTypeExpectation('arg'),
            (new ExpectationFactory)->createExpectation('expectReturnType', ['arg'])
        );
    }

    function testCreateReturnExpectation()
    {
        $this->assertEquals(
            new ReturnExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation('expectReturn', ['arg'])
        );
    }

    function testCreateEmptyExpectation()
    {
        $this->assertEquals(
            new NullExpectation,
            (new ExpectationFactory)->createExpectation('expectNothing', [])
        );
    }

    function testCaseInsensitivity()
    {
        $this->assertEquals(
            new NullExpectation,
            (new ExpectationFactory)->createExpectation('EXPECTNothing', [])
        );
    }

    function testDefaultArgument()
    {
        $this->assertEquals(
            new ExceptionExpectation(''),
            (new ExpectationFactory)->createExpectation('expectException', [])
        );
    }
}
