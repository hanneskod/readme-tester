<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use hanneskod\readmetester\Regexp;

class OutputExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $expectation->validate(new Result('', 'bar'));
    }

    public function testMatch()
    {
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $this->assertNull(
            $expectation->validate(new Result('', 'foo'))
        );
    }
}
