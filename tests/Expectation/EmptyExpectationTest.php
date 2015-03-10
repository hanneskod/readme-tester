<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class EmptyExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $expectation = new EmptyExpectation;
        $this->assertNull(
            $expectation->validate(new Result('', ''))
        );
    }
}
