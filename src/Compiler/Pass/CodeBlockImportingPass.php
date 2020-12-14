<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;

/**
 * Merge code from contexts and named imports into examples
 */
final class CodeBlockImportingPass implements CompilerPassInterface
{
    public function process(ExampleStoreInterface $store): ExampleStoreInterface
    {
        $contexts = [];
        $map = [];
        $done = [];

        foreach ($store->getExamples() as $example) {
            $exampleName = $example->getName()->getFullName();
            $namespace = $example->getName()->getNamespaceName();

            // Create context collection for this namespace
            if (!isset($contexts[$namespace])) {
                $contexts[$namespace] = [];
            }

            // Save names of example contexts
            if ($example->isContext()) {
                $contexts[$namespace][] = $exampleName;
            }

            // Create a map of name to example
            $map[$exampleName] = $example;
        }

        foreach ($map as $exampleName => $example) {
            // List contexts and imports once (array_flip implies uniqueness)
            $imports = array_flip([
                ...$contexts[$example->getName()->getNamespaceName()] ?? [],
                ...array_map(fn($name) => $name->getFullName(), $example->getImports()),
            ]);

            // Remove current example if in list
            unset($imports[$exampleName]);

            // Setup the new code block
            $codeBlock = $example->getCodeBlock();

            // Iterate over keys in reverse order as we prepend code..
            foreach (array_reverse(array_keys($imports)) as $import) {
                if (!isset($map[$import])) {
                    throw new \RuntimeException(
                        "Unable to import example '$import' into '$exampleName', example does not exist"
                    );
                }

                $codeBlock = $codeBlock->prepend($map[$import]->getCodeBlock());
            }

            $done[] = $example->withCodeBlock($codeBlock);
        }

        return new ArrayExampleStore($done);
    }
}
