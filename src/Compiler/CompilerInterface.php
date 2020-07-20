<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

interface CompilerInterface
{
    /**
     * @param array<InputInterface> $inputs
     */
    public function compile(array $inputs): ExampleStoreInterface;
}
