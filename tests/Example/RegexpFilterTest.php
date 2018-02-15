<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

class RegexpFilterTest extends \PHPUnit\Framework\TestCase
{
    function testIsValid()
    {
        $filter = new RegexpFilter('foo');

        $this->assertFalse(
            $filter->isValid('bar')
        );

        $this->assertTrue(
            $filter->isValid('foo')
        );
    }
}
