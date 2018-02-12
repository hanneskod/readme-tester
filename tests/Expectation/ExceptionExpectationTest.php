<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ExceptionExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertInternalType('string', (string)new ExceptionExpectation(''));
    }

    public function testHandles()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getType()->willReturn(OutcomeInterface::TYPE_EXCEPTION);
        $this->assertTrue((new ExceptionExpectation(''))->handles($outcome->reveal()));
    }

    public function testWrongException()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['class' => 'bar']);
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ExceptionExpectation('foo'))->handle($outcome->reveal())
        );
    }

    public function testValidException()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['class' => 'foo']);
        $this->assertInstanceOf(
            Success::CLASS,
            (new ExceptionExpectation('foo'))->handle($outcome->reveal())
        );
    }
}
