<?php

namespace hanneskod\readmetester;

class ExampleTest extends \PHPUnit_Framework_TestCase
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
