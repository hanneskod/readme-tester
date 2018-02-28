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

    public function testVoidOutcome()
    {
        $this->assertInstanceOf(
            VoidOutcome::CLASS,
            $this->createRunner()->run(new CodeBlock('$a = 1 + 2;'))
        );
    }

    public function testOutput()
    {
        $this->assertEquals(
            new OutputOutcome('foo'),
            $this->createRunner()->run(new CodeBlock('echo "foo";'))
        );
    }

    public function testException()
    {
        $this->assertInstanceOf(
            ErrorOutcome::CLASS,
            $this->createRunner()->run(new CodeBlock('throw new Exception;'))
        );
    }

    public function testTriggerError()
    {
        $this->assertInstanceOf(
            ErrorOutcome::CLASS,
            $this->createRunner()->run(new CodeBlock('trigger_error("ERROR");'))
        );
    }

    public function testFatalError()
    {
        $this->assertInstanceOf(
            ErrorOutcome::CLASS,
            $this->createRunner()->run(new CodeBlock('this_function_does_not_exist();'))
        );
    }
}
