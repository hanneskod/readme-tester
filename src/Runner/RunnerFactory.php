<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Exception\InstantiatorException;
use hanneskod\readmetester\Exception\InvalidRunnerException;
use hanneskod\readmetester\Utils\Instantiator;

final class RunnerFactory
{
    public function __construct(
        private Instantiator $instantiator,
    ) {}

    public function createRunner(string $id): RunnerInterface
    {
        try {
            $runner = $this->instantiator->getNewObject(
                Configs::expand(Configs::RUNNER_ID, $id),
            );
        } catch (InstantiatorException $exception) {
            throw new InvalidRunnerException("Invalid runner $id: {$exception->getMessage()}");
        }

        if (!$runner instanceof RunnerInterface) {
            throw new InvalidRunnerException(
                "Invalid runner $id: Class does not implement RunnerInterface"
            );
        }

        return $runner;
    }
}
