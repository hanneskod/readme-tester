<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class Name extends AbstractAttribute implements TransformationInterface
{
    protected string $name;

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
        return $example->withName(
            NameObj::fromString($this->name, $example->getName()->getNamespaceName())
        );
    }
}
