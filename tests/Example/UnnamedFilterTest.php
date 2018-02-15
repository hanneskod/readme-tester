<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

class UnnamedFilterTest extends \PHPUnit\Framework\TestCase
{
    function testIsValid()
    {
        $this->assertFalse(
            (new UnnamedFilter)->isValid('')
        );

        $this->assertTrue(
            (new UnnamedFilter)->isValid('some-name')
        );
    }
}
