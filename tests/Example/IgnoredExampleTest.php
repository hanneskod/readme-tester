<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Parser\CodeBlock;

class IgnoredExampleTest extends \PHPUnit\Framework\TestCase
{
    function testShouldBeEaluated()
    {
        $this->assertFalse(
            (new IgnoredExample($this->createMock(NameInterface::CLASS), $this->createMock(CodeBlock::CLASS), []))
                ->shouldBeEvaluated()
        );
    }
}
