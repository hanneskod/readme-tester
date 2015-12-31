<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class ReturnExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new ReturnExpectation(new Regexp('/foo/'));
        $expectation->validate(new Result('bar', ''));
    }

    public function testMatch()
    {
        $expectation = new ReturnExpectation(new Regexp('/foo/'));
        $this->assertNull(
            $expectation->validate(new Result('foo', ''))
        );
    }
}
