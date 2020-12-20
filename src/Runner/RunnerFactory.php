<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Utils\Instantiator;

final class RunnerFactory
{
    public function __construct(
        private Instantiator $instantiator,
    ) {}

    public function createRunner(string $id): RunnerInterface
    {
        $runner = $this->instantiator->getNewObject(
            Configs::expand(Configs::RUNNER_ID, $id),
        );

        if (!$runner instanceof RunnerInterface) {
            throw new \RuntimeException("$id does no implement RunnerInterface");
        }

        return $runner;
    }
}
