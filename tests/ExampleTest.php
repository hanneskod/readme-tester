<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

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
        $expectations = [$this->prophesize(Expectation\ExpectationInterface::CLASS)->reveal()];
        $this->assertSame(
            $expectations,
            (new Example('', $this->prophesize(CodeBlock::CLASS)->reveal(), $expectations))->getExpectations()
        );
    }
}
