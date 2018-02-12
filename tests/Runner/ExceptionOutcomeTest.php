<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class ExceptionOutcomeTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertSame(
            OutcomeInterface::TYPE_EXCEPTION,
            (new ExceptionOutcome('', '', 0))->getType()
        );
    }

    public function testPayload()
    {
        $this->assertSame(
            [
                'class' => 'class',
                'message' => 'msg',
                'code' => 1
            ],
            (new ExceptionOutcome('class', 'msg', 1))->getPayload()
        );
    }

    public function testToString()
    {
        $this->assertSame(
            "exception 'foobar'",
            (string)new ExceptionOutcome('foobar', '', 0)
        );
    }
}
