<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

class IsolationRunnerTest extends AbstractRunnerTest
{
    public function createRunner(): RunnerInterface
    {
        return new IsolationRunner;
    }

    public function testIsolation()
    {
        $runner = $this->createRunner();
        $this->assertEmpty($runner->run(new CodeBlock('class Foo {}')));
        $this->assertEmpty($runner->run(new CodeBlock('class Foo {}')));
    }

    public function testReturnScalar()
    {
        $this->markTestIncomplete('Isolation test runner does not support asserting return values');
    }

    public function testReturnObject()
    {
        $this->markTestIncomplete('Isolation test runner does not support asserting return values');
    }
}
