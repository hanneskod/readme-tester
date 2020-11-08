<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;

#[\Attribute]
class IgnoreUnmarkedExamples implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleObj $example): ExampleObj
    {
        foreach ($example->getAttributes() as $attribute) {
            if ($attribute instanceof Example) {
                return $example;
            }
        }

        return $example->withActive(false);
    }
}
