<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class Import extends AbstractAttribute implements TransformationInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->name);
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withImport(
            NameObj::fromString($this->name, $example->getName()->getNamespaceName())
        );
    }
}
