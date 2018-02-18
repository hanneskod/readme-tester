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

    public function testPayload()
    {
        $this->assertSame(
            ['error' => 'foobar'],
            (new ErrorOutcome('foobar'))->getPayload()
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
