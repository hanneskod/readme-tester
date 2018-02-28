<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ErrorExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertInternalType('string', (string)new ErrorExpectation(new Regexp('')));
    }

    public function testHandles()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getType()->willReturn(OutcomeInterface::TYPE_ERROR);
        $this->assertTrue((new ErrorExpectation(new Regexp('')))->handles($outcome->reveal()));
    }

    public function testNoMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getContent()->willReturn('bar');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ErrorExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }

    public function testMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getContent()->willReturn('foo');
        $this->assertInstanceOf(
            Success::CLASS,
            (new ErrorExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }
}
