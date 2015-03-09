<?php

namespace hanneskod\readmetester;

class ExpectationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNothing()
    {
        $this->assertNull(
            (new ExpectationFactory)->createExpectation('foo', 'bar')
        );
    }

    public function testCreateExceptionExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ExceptionExpectation',
            (new ExpectationFactory)->createExpectation('expectException', 'data')
        );
    }

    public function testCreateOutputExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\OutputExpectation',
            (new ExpectationFactory)->createExpectation('expectOutput', 'data')
        );
    }

    public function testCreateReturnTypeExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnTypeExpectation',
            (new ExpectationFactory)->createExpectation('expectReturnType', 'data')
        );
    }

    public function testCreateReturnExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnExpectation',
            (new ExpectationFactory)->createExpectation('expectReturn', 'data')
        );
    }

    public function testCreateEmptyExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\EmptyExpectation',
            (new ExpectationFactory)->createExpectation('expectNothing', 'data')
        );
    }
}
