<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;

#<<\PhpAttribute>>
class ExampleContext implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withIsContext(true);
    }
}
