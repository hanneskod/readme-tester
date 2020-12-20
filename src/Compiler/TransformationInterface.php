<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleObj;

interface TransformationInterface
{
    public function transform(ExampleObj $example): ExampleObj;
}
