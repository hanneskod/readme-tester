<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

class FailureTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertSame(
            'foobar',
            (string)new Failure('foobar')
        );
    }

    public function testIsFailure()
    {
        $this->assertFalse((new Failure(''))->isSuccess());
    }
}
