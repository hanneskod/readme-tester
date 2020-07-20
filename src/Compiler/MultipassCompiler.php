<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

final class MultipassCompiler implements CompilerInterface
{
    private CompilerInterface $decoratedCompiler;

    /**
     * @var array<CompilerPassInterface>
     */
    private array $compilerPasses;

    /**
     * @param array<CompilerPassInterface> $compilerPasses
     */
    public function __construct(CompilerInterface $decoratedCompiler, array $compilerPasses)
    {
        $this->decoratedCompiler = $decoratedCompiler;
        $this->compilerPasses = $compilerPasses;
    }

    public function compile(array $inputs): ExampleStoreInterface
    {
        $store = $this->decoratedCompiler->compile($inputs);

        foreach ($this->compilerPasses as $pass) {
            $store = $pass->process($store);
        }

        return $store;
    }
}
