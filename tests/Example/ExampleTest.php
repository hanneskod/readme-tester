<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Parser\CodeBlock;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    function testGetName()
    {
        $this->assertSame(
            'foobar',
            (new Example('foobar', $this->prophesize(CodeBlock::CLASS)->reveal(), []))->getName()
        );
    }

    function testShouldBeEaluated()
    {
        $this->assertTrue(
            (new Example('', $this->prophesize(CodeBlock::CLASS)->reveal(), []))->shouldBeEvaluated()
        );
    }

    function testGetCodeBlock()
    {
        $code = $this->prophesize(CodeBlock::CLASS)->reveal();
        $this->assertSame(
            $code,
            (new Example('', $code, []))->getCodeBlock()
        );
    }

    function testGetExpectations()
    {
        $expectations = [$this->prophesize(ExpectationInterface::CLASS)->reveal()];
        $this->assertSame(
            $expectations,
            (new Example('', $this->prophesize(CodeBlock::CLASS)->reveal(), $expectations))->getExpectations()
        );
    }
}
