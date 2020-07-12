<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Utils\Name;

#<<\PhpAttribute>>
class NamespaceName implements TransformationInterface
{
    use AttributeFactoryTrait;

    private string $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withName(
            new Name(
                $this->namespace,
                $example->getName()->getShortName()
            )
        );
    }
}
