<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;

#[\Attribute]
class Name implements TransformationInterface
{
    use AttributeFactoryTrait;

    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withName(
            NameObj::fromString($this->name, $example->getName()->getNamespaceName())
        );
    }
}
