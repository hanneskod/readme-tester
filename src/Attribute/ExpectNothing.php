<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Attribute;

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Expectation\VoidExpectation;

#[\Attribute(\Attribute::IS_REPEATABLE|\Attribute::TARGET_ALL)]
class ExpectNothing implements AttributeInterface, TransformationInterface
{
    use AttributeFactoryTrait;

    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withExpectation(new VoidExpectation);
    }
}
