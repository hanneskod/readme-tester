<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ReturnExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertInternalType('string', (string)new ReturnExpectation(new Regexp('')));
    }

    public function testHandles()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getType()->willReturn(OutcomeInterface::TYPE_RETURN);
        $this->assertTrue((new ReturnExpectation(new Regexp('')))->handles($outcome->reveal()));
    }

    public function testNoMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['value' => 'bar']);
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ReturnExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }

    public function testMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['value' => 'foo']);
        $this->assertInstanceOf(
            Success::CLASS,
            (new ReturnExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }
}
