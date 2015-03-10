<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use Exception;

class ExceptionExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoException()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new ExceptionExpectation('foo');
        $expectation->validate(new Result('', '', null));
    }

    public function testWrongException()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new ExceptionExpectation('foo');
        $expectation->validate(new Result('', '', new Exception));
    }

    public function testValidException()
    {
        $expectation = new ExceptionExpectation('Exception');
        $this->assertNull(
            $expectation->validate(new Result('', '', new Exception))
        );
    }
}
