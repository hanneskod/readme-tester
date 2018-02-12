<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

class EvalRunnerTest extends \PHPUnit\Framework\TestCase
{
    function testNoOutcome()
    {
        $this->assertEmpty(
            (new EvalRunner)->run(new CodeBlock('$a = 1 + 2;'))
        );
    }

    function testOutput()
    {
        $this->assertEquals(
            new OutputOutcome('foo'),
            (new EvalRunner)->run(new CodeBlock('echo "foo";'))[0]
        );
    }

    function testReturnScalar()
    {
        $this->assertEquals(
            new ReturnOutcome('1234', 'integer', ''),
            (new EvalRunner)->run(new CodeBlock('return 1234;'))[0]
        );
    }

    function testReturnObject()
    {
        $this->assertEquals(
            new ReturnOutcome('', 'object', 'A'),
            (new EvalRunner)->run(new CodeBlock('class A {} return new A;'))[0]
        );
    }

    function testException()
    {
        $this->assertEquals(
            new ExceptionOutcome('Exception', 'msg', 10),
            (new EvalRunner)->run(new CodeBlock('throw new Exception("msg", 10);'))[0]
        );
    }
}
