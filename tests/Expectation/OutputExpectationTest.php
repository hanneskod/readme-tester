<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;
use hanneskod\readmetester\Regexp;

class OutputExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new OutputExpectation(new Regexp('/foo/')))->validate(new Result('', 'bar'));
    }

    public function testMatch()
    {
        $this->assertNull(
            (new OutputExpectation(new Regexp('/foo/')))->validate(new Result('', 'foo'))
        );
    }
}
