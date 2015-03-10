<?php

namespace hanneskod\readmetester;

class ExpectationFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $expectationFactory;

    public function setup()
    {
        $this->expectationFactory = new ExpectationFactory;
    }

    public function testCreateNothing()
    {
        $this->assertNull(
            $this->expectationFactory->createExpectation('foo', 'bar')
        );
    }

    public function testCreateExceptionExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ExceptionExpectation',
            $this->expectationFactory->createExpectation('expectException', 'data')
        );
    }

    public function testCreateOutputExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\OutputExpectation',
            $this->expectationFactory->createExpectation('expectOutput', 'data')
        );
    }

    public function testCreateReturnTypeExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnTypeExpectation',
            $this->expectationFactory->createExpectation('expectReturnType', 'data')
        );
    }

    public function testCreateReturnExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnExpectation',
            $this->expectationFactory->createExpectation('expectReturn', 'data')
        );
    }

    public function testCreateEmptyExpectation()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\EmptyExpectation',
            $this->expectationFactory->createExpectation('expectNothing', 'data')
        );
    }
}
