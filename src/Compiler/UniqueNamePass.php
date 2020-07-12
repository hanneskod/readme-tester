<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

/**
 * Assert that all examples in store have unique names
 */
final class UniqueNamePass implements CompilerPassInterface
{
    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        $names = [];

        foreach ($store->getExamples() as $example) {
            $name = $example->getName()->getFullName();

            if (isset($names[$name])) {
                throw new \RuntimeException("Unable to create example '$name', name already exists");
            }

            $names[$name] = true;
        }

        return $store;
    }
}
