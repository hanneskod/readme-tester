<?php

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleStoreInterface;

/**
 * Defines object that are able to execute example code
 */
interface RunnerInterface
{
    /** @return iterable<OutcomeInterface> */
    public function run(ExampleStoreInterface $examples): iterable;

    public function setBootstrap(string $filename): void;
}
