<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleInterface;

interface TransformationInterface
{
    public function transform(ExampleInterface $example): ExampleInterface;
}
