<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

class FailureTest extends \PHPUnit\Framework\TestCase
{
    public function testDescription()
    {
        $this->assertSame(
            'foobar',
            (new Failure('foobar'))->getDescription()
        );
    }

    public function testIsFailure()
    {
        $this->assertFalse((new Failure(''))->isSuccess());
    }
}
