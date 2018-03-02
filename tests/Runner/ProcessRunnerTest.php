<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

class ProcessRunnerTest extends AbstractRunnerTest
{
    public function createRunner(string $bootstrap = ''): RunnerInterface
    {
        return new ProcessRunner($bootstrap);
    }

    public function testIsolation()
    {
        $runner = $this->createRunner();

        $this->assertInstanceOf(
            VoidOutcome::CLASS,
            $runner->run(new CodeBlock('class Foo {}'))
        );

        $this->assertInstanceOf(
            VoidOutcome::CLASS,
            $runner->run(new CodeBlock('class Foo {}'))
        );
    }
}
