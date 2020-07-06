<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;

/**
 * Perform example transformations
 */
final class TransformationPass implements CompilerPassInterface
{
    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        $examples = [];

        foreach ($store->getExamples() as $example) {
            foreach ($example->getAttributes() as $attribute) {
                if ($attribute instanceof TransformationInterface) {
                    $example = $attribute->transform($example);
                }
            }

            $examples[] = $example;
        }

        return new ArrayExampleStore($examples);
    }
}
