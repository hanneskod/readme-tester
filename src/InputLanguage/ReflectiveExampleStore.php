<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\InputLanguage;

use hanneskod\readmetester\Attribute\AttributeInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\NameObj;

/**
 * Extract examples from concrete class using reflection
 */
abstract class ReflectiveExampleStore implements ExampleStoreInterface
{
    const EXAMPLE_METHOD_PREFIX = 'example';

    public function getExamples(): iterable
    {
        $reflectionClass = new \ReflectionClass($this);

        $globalAttributes = $this->extractAttributes($reflectionClass->getConstructor());

        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if (!str_starts_with($reflectionMethod->getName(), self::EXAMPLE_METHOD_PREFIX)) {
                continue;
            }

            if ($reflectionMethod->getNumberOfRequiredParameters()) {
                throw new \LogicException(
                    "{$reflectionClass->getName()}::{$reflectionMethod->getName()}() requires unknown parameters"
                );
            }

            $code = $reflectionMethod->invoke($this);

            if (!is_string($code)) {
                throw new \LogicException(
                    "{$reflectionClass->getName()}::{$reflectionMethod->getName()}() did not return a string"
                );
            }

            yield new ExampleObj(
                new NameObj('', $reflectionMethod->getName()),
                new CodeBlock($code),
                [...$globalAttributes, ...$this->extractAttributes($reflectionMethod)]
            );
        }
    }

    /** @return array<AttributeInterface> */
    private function extractAttributes(?\ReflectionMethod $reflectionMethod): array
    {
        if (!$reflectionMethod) {
            return [];
        }

        return array_map(
            fn($attribute) => $attribute->newInstance(),
            $reflectionMethod->getAttributes(
                AttributeInterface::class,
                \ReflectionAttribute::IS_INSTANCEOF
            )
        );
    }
}
