<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

use hanneskod\readmetester\Attribute\NamespaceName;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Loader;

class ReflectiveExampleStoreTemplate
{
    private const CLASS_TEMPLATE = <<<CLASS_TEMPLATE
use hanneskod\\readmetester\\Attribute as ReadmeTester;
return new class() extends \\hanneskod\\readmetester\\Input\\ReflectiveExampleStore
{
    %s
    function __construct() {}

    %s
};
CLASS_TEMPLATE;

    private const METHOD_TEMPLATE = <<<METHOD_TEMPLATE
%s
    function %s(): string
    {
    return <<<'___example_code_delimiter___'
%s
___example_code_delimiter___;
    }

METHOD_TEMPLATE;

    /**
     * @param array<string> $globalAttributes
     * @param array<Definition> $definitions
     */
    public function __construct(
        private array $globalAttributes = [],
        private array $definitions = [],
    ) {}

    public function setDefaultNamespace(string $namespace): void
    {
        array_unshift(
            $this->globalAttributes,
            NamespaceName::createAttribute($namespace)
        );
    }

    public function render(): ExampleStoreInterface
    {
        return Loader::load($this->getCode());
    }

    private function getCode(): string
    {
        return sprintf(
            self::CLASS_TEMPLATE,
            implode("\n", $this->globalAttributes),
            array_reduce(
                $this->definitions,
                fn($carry, $definition) => $carry .= sprintf(
                    self::METHOD_TEMPLATE,
                    implode("\n    ", $definition->attributes),
                    uniqid(ReflectiveExampleStore::EXAMPLE_METHOD_PREFIX),
                    $definition->code
                )
            )
        );
    }
}
