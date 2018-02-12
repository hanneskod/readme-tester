<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

class SuccessTest extends \PHPUnit\Framework\TestCase
{
    public function testDescription()
    {
        $this->assertSame(
            'foobar',
            (new Success('foobar'))->getDescription()
        );
    }

    public function testIsSuccess()
    {
        $this->assertTrue((new Success(''))->isSuccess());
    }
}
