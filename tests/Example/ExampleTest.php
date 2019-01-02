<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Name\NameInterface;
use hanneskod\readmetester\Parser\CodeBlock;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    function testGetName()
    {
        $name = $this->createMock(NameInterface::CLASS);
        $this->assertSame(
            $name,
            (new Example($name, $this->createMock(CodeBlock::CLASS), []))->getName()
        );
    }

    function testShouldBeEaluated()
    {
        $this->assertTrue(
            (new Example($this->createMock(NameInterface::CLASS), $this->createMock(CodeBlock::CLASS), []))
                ->shouldBeEvaluated()
        );
    }

    function testGetCodeBlock()
    {
        $code = $this->prophesize(CodeBlock::CLASS)->reveal();
        $this->assertSame(
            $code,
            (new Example($this->createMock(NameInterface::CLASS), $code, []))->getCodeBlock()
        );
    }

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
