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

    public function testMustBeHandled()
    {
        $this->assertTrue(
            (new OutputOutcome(''))->mustBeHandled()
        );
    }

    public function testContent()
    {
        $this->assertSame(
            'foobar',
            (new OutputOutcome('foobar'))->getContent()
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
