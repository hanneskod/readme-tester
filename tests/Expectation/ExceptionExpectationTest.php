<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

class ExceptionExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testNoException()
    {
        $expectation = new ExceptionExpectation('foo');
        $this->assertInstanceOf(
            Failure::CLASS,
            $expectation->validate(new Result('', '', null))
        );
    }

    public function testWrongException()
    {
        $expectation = new ExceptionExpectation('foo');
        $this->assertInstanceOf(
            Failure::CLASS,
            $expectation->validate(new Result('', '', new \Exception))
        );
    }

    public function testValidException()
    {
        $expectation = new ExceptionExpectation('Exception');
        $this->assertInstanceOf(
            Success::CLASS,
            $expectation->validate(new Result('', '', new \Exception))
        );
    }
}
