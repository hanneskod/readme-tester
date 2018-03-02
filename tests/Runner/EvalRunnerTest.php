<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

class EvalRunnerTest extends AbstractRunnerTest
{
    public function createRunner(string $bootstrap = ''): RunnerInterface
    {
        return new EvalRunner($bootstrap);
    }
}
