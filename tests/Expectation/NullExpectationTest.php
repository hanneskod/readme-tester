<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class NullExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $expectation = new NullExpectation;
        $this->assertNull(
            $expectation->validate(new Result('', ''))
        );
    }
}
