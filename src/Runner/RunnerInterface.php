<?php

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

/**
 * Defines object that are able to execute example code
 */
interface RunnerInterface
{
    public function run(ExampleObj $example): OutcomeInterface;

    public function setBootstrap(string $filename): void;
}
