<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class OutputExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertInternalType('string', (string)new OutputExpectation(new Regexp('')));
    }

    public function testHandles()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getType()->willReturn(OutcomeInterface::TYPE_OUTPUT);
        $this->assertTrue((new OutputExpectation(new Regexp('')))->handles($outcome->reveal()));
    }

    public function testNoMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getContent()->willReturn('bar');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new OutputExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }

    public function testMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getContent()->willReturn('foo');
        $this->assertInstanceOf(
            Success::CLASS,
            (new OutputExpectation(new Regexp('/foo/')))->handle($outcome->reveal())
        );
    }
}
