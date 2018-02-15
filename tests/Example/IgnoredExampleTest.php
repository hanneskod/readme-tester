<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Parser\CodeBlock;

class IgnoredExampleTest extends \PHPUnit\Framework\TestCase
{
    function testShouldBeEaluated()
    {
        $this->assertFalse(
            (new IgnoredExample('', $this->prophesize(CodeBlock::CLASS)->reveal(), []))->shouldBeEvaluated()
        );
    }
}
