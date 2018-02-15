<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

class NullFilterTest extends \PHPUnit\Framework\TestCase
{
    function testIsValid()
    {
        $this->assertTrue(
            (new NullFilter)->isValid('')
        );
    }
}
