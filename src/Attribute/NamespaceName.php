<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class NamespaceName extends AbstractAttribute implements TransformationInterface
{
    private string $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function asAttribute(): string
    {
        return self::createAttribute($this->namespace);
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withName(
            new NameObj(
                $this->namespace,
                $example->getName()->getShortName()
            )
        );
    }
}
