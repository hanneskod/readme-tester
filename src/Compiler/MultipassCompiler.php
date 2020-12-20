<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Example\ExampleStoreInterface;

final class MultipassCompiler implements CompilerInterface
{
    /**
     * @param array<CompilerPassInterface> $compilerPasses
     */
    public function __construct(
        private CompilerInterface $decoratedCompiler,
        private array $compilerPasses = [],
    ) {}

    public function compile(iterable $inputs): ExampleStoreInterface
    {
        $store = $this->decoratedCompiler->compile($inputs);

        foreach ($this->compilerPasses as $pass) {
            $store = $pass->process($store);
        }

        return $store;
    }
}
