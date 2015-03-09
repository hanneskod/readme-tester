<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use Exception;

class ExceptionExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoException()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new ExceptionExpectation('foo'))->validate(new Result('', '', null));
    }

    public function testWrongException()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new ExceptionExpectation('foo'))->validate(new Result('', '', new Exception));
    }

    public function testValidException()
    {
        $this->assertNull(
            (new ExceptionExpectation('Exception'))->validate(new Result('', '', new Exception))
        );
    }
}
