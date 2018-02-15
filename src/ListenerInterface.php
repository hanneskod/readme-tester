<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\Example;
use hanneskod\readmetester\Expectation\Status;

/**
 * Interface for listening on testing progress
 */
interface ListenerInterface
{
    /**
     * Called on example evaluation
     */
    public function onExample(Example $example): void;

    /**
     * Called when an example is skipped
     */
    public function onIgnoredExample(Example $example): void;

    /**
     * Called on expectation evaluation
     *
     * Note that the previous call to onExample() identifies the current example
     */
    public function onExpectation(Status $status): void;
}
