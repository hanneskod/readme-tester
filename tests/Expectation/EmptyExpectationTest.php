<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class EmptyExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $this->assertNull(
            (new EmptyExpectation)->validate(new Result('', ''))
        );
    }
}
