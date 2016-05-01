<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class NullExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testMatch()
    {
        $expectation = new NullExpectation;
        $this->assertInstanceOf(
            'hanneskod\readmetester\Expectation\ReturnObj\Success',
            $expectation->validate(new Result('', ''))
        );
    }
}
