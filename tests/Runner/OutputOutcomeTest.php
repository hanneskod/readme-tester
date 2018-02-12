<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class OutputOutcomeTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertSame(
            OutcomeInterface::TYPE_OUTPUT,
            (new OutputOutcome(''))->getType()
        );
    }

    public function testPayload()
    {
        $this->assertSame(
            ['output' => 'foobar'],
            (new OutputOutcome('foobar'))->getPayload()
        );
    }

    public function testToString()
    {
        $this->assertSame(
            "output 'foobar'",
            (string)new OutputOutcome('foobar')
        );
    }
}
