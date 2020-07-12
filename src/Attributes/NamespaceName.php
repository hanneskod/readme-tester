<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\NameObj;

#<<\PhpAttribute>>
class NamespaceName implements TransformationInterface
{
    use AttributeFactoryTrait;

    private string $namespace;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
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
