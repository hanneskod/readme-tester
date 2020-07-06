<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

interface CompilerPassInterface
{
    public function process(ExampleStoreInterface $store): ExampleStoreInterface;
}
