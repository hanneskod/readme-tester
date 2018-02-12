<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ReturnTypeExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertInternalType('string', (string)new ReturnTypeExpectation(''));
    }

    public function testHandles()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getType()->willReturn(OutcomeInterface::TYPE_RETURN);
        $this->assertTrue((new ReturnTypeExpectation(''))->handles($outcome->reveal()));
    }

    public function testNoMatch()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['type' => 'bar', 'class' => 'bar']);
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ReturnTypeExpectation('foo'))->handle($outcome->reveal())
        );
    }

    public function testMatchType()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['type' => 'FOO', 'class' => 'bar']);
        $this->assertInstanceOf(
            Success::CLASS,
            (new ReturnTypeExpectation('foo'))->handle($outcome->reveal())
        );
    }

    public function testMatchClass()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->getPayload()->willReturn(['type' => 'bar', 'class' => 'FOO']);
        $this->assertInstanceOf(
            Success::CLASS,
            (new ReturnTypeExpectation('foo'))->handle($outcome->reveal())
        );
    }
}
