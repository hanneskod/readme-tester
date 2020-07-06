<?php

namespace hanneskod\readmetester\Compiler;

interface CompilerFactoryInterface
{
    public function createCompiler(): CompilerInterface;
}
