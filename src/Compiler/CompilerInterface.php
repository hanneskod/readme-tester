<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

interface CompilerInterface
{
    public function compile(InputInterface ...$inputs): ExampleStoreInterface;
}
