<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\CodeBlock;

class EvalRunnerTest extends \PHPUnit\Framework\TestCase
{
    function testReturningResult()
    {
        $this->assertInstanceOf(
            Result::CLASS,
            (new EvalRunner)->run(new CodeBlock('$a = 1 + 2;'))
        );
    }

    function testOutput()
    {
        $this->assertSame(
            'foo',
            (new EvalRunner)->run(new CodeBlock('echo "foo";'))->getOutput()
        );
    }

    function testReturnValue()
    {
        $this->assertSame(
            1234,
            (new EvalRunner)->run(new CodeBlock('return 1234;'))->getReturnValue()
        );
    }

    function testException()
    {
        $this->assertInstanceOf(
            \Exception::CLASS,
            (new EvalRunner)->run(new CodeBlock('throw new Exception;'))->getException()
        );
    }
}
