<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\StatusInterface;

/**
 * Interface for listening on testing progress
 */
interface ListenerInterface
{
    /**
     * Called on example evaluation
     */
    public function onExample(ExampleObj $example): void;

    /**
     * Called when an example is skipped
     */
    public function onIgnoredExample(ExampleObj $example): void;

    /**
     * Called on expectation evaluation
     *
     * Note that the previous call to onExample() identifies the current example
     */
    public function onExpectation(StatusInterface $status): void;
}
