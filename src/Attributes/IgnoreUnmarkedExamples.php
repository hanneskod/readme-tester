<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleInterface;

#<<\PhpAttribute>>
class IgnoreUnmarkedExamples implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleInterface $example): ExampleInterface
    {
        foreach ($example->getAttributes() as $attribute) {
            if ($attribute instanceof Example) {
                return $example;
            }
        }

        return $example->withActive(false);
    }
}
