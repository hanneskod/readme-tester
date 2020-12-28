<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class Ignore extends AbstractAttribute implements TransformationInterface
{
    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withActive(false);
    }
}
