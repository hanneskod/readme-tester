<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\NameObj;

/**
 * Extract examples from concrete class using reflection
 */
abstract class ReflectionExampleStore implements ExampleStoreInterface
{
    const EXAMPLE_PREFIX = 'example';

    public function getExamples(): iterable
    {
        // Iterate over public methods in concrete class
        foreach ((new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            // Find methods starting with the example prefix
            if (strpos($method->name, self::EXAMPLE_PREFIX) === 0) {
                $attributes = [];

                // TODO attributes should be extracted using php 8 attributes instead
                // this is just a quick hack that expexts all docblock lines to be like:
                // * new fully\qualified\attribute\classname
                foreach (explode(PHP_EOL, (string)$method->getDocComment()) as $line) {
                    if (preg_match('/^\s*\*\s*(new.+)/', $line, $matches)) {
                        $attributes[] = eval("return {$matches[1]};");
                    }
                }

                // TODO throw LogicException if method requires arguments to be invoked
                // TODO throw LogicException if method is abstract (not invokable)
                // TODO throw LogicException if method does not return a string

                yield new ExampleObj(
                    new NameObj('', $method->name),
                    new CodeBlock($method->invoke($this)),
                    $attributes
                );
            }
        }
    }
}
