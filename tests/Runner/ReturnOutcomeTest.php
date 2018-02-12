<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class ReturnOutcomeTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertSame(
            OutcomeInterface::TYPE_RETURN,
            (new ReturnOutcome('', '', ''))->getType()
        );
    }

    public function testPayload()
    {
        $this->assertSame(
            [
                'value' => 'value',
                'type' => 'type',
                'class' => 'class'
            ],
            (new ReturnOutcome('value', 'type', 'class'))->getPayload()
        );
    }

    public function testToString()
    {
        $this->assertSame(
            "return value 'foobar'",
            (string)new ReturnOutcome('foobar', '', '')
        );
    }
}
