<?php

namespace hanneskod\readmetester\Compiler;

interface CompilerFactoryInterface
{
    /** @param array<CompilerPassInterface> $compilerPasses */
    public function createCompiler(array $compilerPasses = []): CompilerInterface;
}
