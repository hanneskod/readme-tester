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
}
