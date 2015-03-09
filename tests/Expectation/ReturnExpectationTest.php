<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use hanneskod\readmetester\Regexp;

class ReturnExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new ReturnExpectation(new Regexp('/foo/')))->validate(new Result('bar', ''));
    }

    public function testMatch()
    {
        $this->assertNull(
            (new ReturnExpectation(new Regexp('/foo/')))->validate(new Result('foo', ''))
        );
    }
}
