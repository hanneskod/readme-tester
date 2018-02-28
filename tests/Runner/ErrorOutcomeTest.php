<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class ErrorOutcomeTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertSame(
            OutcomeInterface::TYPE_ERROR,
            (new ErrorOutcome(''))->getType()
        );
    }

    public function testMustBeHandled()
    {
        $this->assertTrue(
            (new ErrorOutcome(''))->mustBeHandled()
        );
    }

    public function testContent()
    {
        $this->assertSame(
            'foobar',
            (new ErrorOutcome('foobar'))->getContent()
        );
    }

    public function testToString()
    {
        $this->assertSame(
            "foobar",
            (string)new ErrorOutcome('foobar')
        );
    }
}
