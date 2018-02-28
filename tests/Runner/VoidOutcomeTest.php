<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class VoidOutcomeTest extends \PHPUnit\Framework\TestCase
{
    public function testType()
    {
        $this->assertSame(
            OutcomeInterface::TYPE_VOID,
            (new VoidOutcome(''))->getType()
        );
    }

    public function testMustBeHandled()
    {
        $this->assertFalse(
            (new VoidOutcome(''))->mustBeHandled()
        );
    }

    public function testContent()
    {
        $this->assertSame(
            '',
            (new VoidOutcome)->getContent()
        );
    }

    public function testToString()
    {
        $this->assertInternalType(
            'string',
            (string)new VoidOutcome
        );
    }
}
