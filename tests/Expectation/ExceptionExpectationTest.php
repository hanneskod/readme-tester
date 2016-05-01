<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class ExceptionExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoException()
    {
        $expectation = new ExceptionExpectation('foo');
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Failure',
            $expectation->validate(new Result('', '', null))
        );
    }

    public function testWrongException()
    {
        $expectation = new ExceptionExpectation('foo');
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Failure',
            $expectation->validate(new Result('', '', new \Exception))
        );
    }

    public function testValidException()
    {
        $expectation = new ExceptionExpectation('Exception');
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Success',
            $expectation->validate(new Result('', '', new \Exception))
        );
    }
}
