<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

class SuccessTest extends \PHPUnit\Framework\TestCase
{
    public function testToString()
    {
        $this->assertSame(
            'foobar',
            (string)new Success('foobar')
        );
    }

    public function testIsSuccess()
    {
        $this->assertTrue((new Success(''))->isSuccess());
    }
}
