<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;

trait OutcomeDefaultsTrait
{
    public function getExample(): ExampleObj
    {
        if (isset($this->example) && $this->example instanceof ExampleObj) {
            return $this->example;
        }

        throw new \LogicException('Unable to get example from trait. Example not set.');
    }

    public function isError(): bool
    {
        return false;
    }

    public function isOutput(): bool
    {
        return false;
    }

    public function isSkipped(): bool
    {
        return false;
    }

    public function isVoid(): bool
    {
        return false;
    }
}
