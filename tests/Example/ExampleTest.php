<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Parser\CodeBlock;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    function testGetExpectations()
    {
        $expectations = [$this->createMock(ExpectationInterface::CLASS)];
        $this->assertSame(
            $expectations,
            (new Example($this->createMock(NameInterface::CLASS), $this->createMock(CodeBlock::CLASS), $expectations))
                ->getExpectations()
        );
    }
}
