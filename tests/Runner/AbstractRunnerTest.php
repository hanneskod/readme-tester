<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Definies the standard tests each runner must pass
 */
abstract class AbstractRunnerTest extends \PHPUnit\Framework\TestCase
{
    abstract public function createRunner(): RunnerInterface;

    public function testNoOutcome()
    {
        $this->assertEmpty(
            $this->createRunner()->run(new CodeBlock('$a = 1 + 2;'))
        );
    }

    public function testOutput()
    {
        $this->assertEquals(
            new OutputOutcome('foo'),
            $this->createRunner()->run(new CodeBlock('echo "foo";'))[0]
        );
    }

    public function testReturnScalar()
    {
        $this->assertEquals(
            new ReturnOutcome('1234', 'integer', ''),
            $this->createRunner()->run(new CodeBlock('return 1234;'))[0]
        );
    }

    public function testReturnObject()
    {
        $this->assertEquals(
            new ReturnOutcome('', 'object', 'A'),
            $this->createRunner()->run(new CodeBlock('class A {} return new A;'))[0]
        );
    }

    public function testException()
    {
        $this->assertEquals(
            new ExceptionOutcome('Exception', 'msg', 10),
            $this->createRunner()->run(new CodeBlock('throw new Exception("msg", 10);'))[0]
        );
    }

    public function testError()
    {
        $this->assertInstanceOf(
            ErrorOutcome::CLASS,
            $this->createRunner()->run(new CodeBlock('trigger_error("ERROR");'))[0]
        );
    }
}
