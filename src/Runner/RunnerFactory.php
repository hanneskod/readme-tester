<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

final class RunnerFactory
{
    const RUNNER_EVAL = 'eval';
    const RUNNER_PROCESS = 'process';

    public function createRunner(string $id): RunnerInterface
    {
        switch (true) {
            case $id == self::RUNNER_EVAL:
                return new EvalRunner;
            case $id == self::RUNNER_PROCESS:
                return new ProcessRunner;
        }

        // TODO create from classname

        throw new \RuntimeException("Unknown runner: $id");
    }
}
