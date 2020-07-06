<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;

#<<\PhpAttribute>>
class Ignore implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleInterface $example): ExampleInterface
    {
        return $example->withActive(false);
    }
}
