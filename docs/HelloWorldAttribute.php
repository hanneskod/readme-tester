<?php

use hanneskod\readmetester\Attribute\AbstractAttribute;
use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class HelloWorldAttribute extends AbstractAttribute implements TransformationInterface
{
    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            new CodeBlock("echo 'hello world';")
        );
    }
}
