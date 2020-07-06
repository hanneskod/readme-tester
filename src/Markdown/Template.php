<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Attributes\NamespaceName;

class Template
{
    private const HEADER = <<<'HEADER'
return new class() extends \hanneskod\readmetester\Markdown\ReflectionExampleStore
{
HEADER;

    private const FOOTER = <<<'FOOTER'
};
FOOTER;

    /**
     * @var array<int, Definition>
     */
    private array $definitions;

    /**
     * @var array<string>
     */
    private array $globalAttributes;

    /**
     * @param array<string> $globalAttributes
     * @param array<int, Definition> $definitions
     */
    public function __construct(array $globalAttributes, array $definitions)
    {
        $this->globalAttributes = $globalAttributes;
        $this->definitions = $definitions;
    }

    public function setDefaultNamespace(string $namespace): void
    {
        array_unshift(
            $this->globalAttributes,
            NamespaceName::createAttribute($namespace)
        );
    }

    public function getCode(): string
    {
        $code = self::HEADER;

        foreach ($this->definitions as $key => $definition) {

            // TODO Attributes! Should be <<Attr>> instead of docblock

            // TODO preg_replace values ska vara konstanter
            // TODO sätt name till example$key som standard. så att alla exempel har i alla fall ett namn...

            $attributesStr = array_reduce(
                array_map(
                    fn($attr) => preg_replace('/^ReadmeTester\\\\/i', '\hanneskod\readmetester\Attributes\\', $attr),
                    [...$this->globalAttributes, ...$definition->attributes]
                ),
                fn($str, $attr) => "$str\n     * new $attr"
            );

            $nowdocId = uniqid('readmetester_example_code_nowdoc_id');

            $code .= <<<METHOD

    /**$attributesStr
     */
    function example$key(): string
    {
        return <<<'$nowdocId'
{$definition->code}
$nowdocId;
    }

METHOD;
        }

        return $code . self::FOOTER;
    }
}
