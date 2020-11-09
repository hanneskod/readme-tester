<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;

#[\Attribute]
class Ignore implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withActive(false);
    }
}