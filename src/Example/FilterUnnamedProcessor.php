<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

/**
 * Filter unnamed examples
 */
final class FilterUnnamedProcessor implements ProcessorInterface
{
    public function process(ExampleInterface $example): ExampleInterface
    {
        if ($example->getName()->isUnnamed()) {
            return $example->withActive(false);
        }

        return $example;
    }
}
