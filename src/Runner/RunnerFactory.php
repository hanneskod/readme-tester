<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Utils\Instantiator;

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

        $runner = Instantiator::instantiate($id);

        if (!$runner instanceof RunnerInterface) {
            throw new \RuntimeException("$id does no implement RunnerInterface");
        }

        return $runner;
    }
}
