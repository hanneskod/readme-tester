<?php

use hanneskod\readmetester\Compiler\TransformationInterface;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;

class HelloWorld implements TransformationInterface
{
    public function transform(ExampleObj $example): ExampleObj
    {
        return $example->withCodeBlock(
            new CodeBlock("echo 'hello world';")
        );
    }
}
