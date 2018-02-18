<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class EvalRunnerTest extends AbstractRunnerTest
{
    public function createRunner(): RunnerInterface
    {
        return new EvalRunner;
    }

    public function testError()
    {
        $this->markTestIncomplete('Error handling is not implemented in EvalRunner');
    }
}
