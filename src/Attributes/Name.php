<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Name\NamespacedName;

#<<\PhpAttribute>>
class Name implements TransformationInterface
{
    use AttributeFactoryTrait;

    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withName(
            NamespacedName::fromString($this->name, $example->getName()->getNamespaceName())
        );
    }
}
