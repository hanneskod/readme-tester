<?php

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

interface CompilerInterface
{
    /**
     * @param iterable<InputInterface> $inputs
     */
    public function compile(iterable $inputs): ExampleStoreInterface;
}
