<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attributes;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\Loader;

#<<\PhpAttribute>>
class Bootstrap implements TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleObj $example): ExampleObj
    {
        Loader::loadOnce($example->getCodeBlock()->getCode());

        return $example->withActive(false);
    }
}
