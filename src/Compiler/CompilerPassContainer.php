<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

final class CompilerPassContainer
{
    /** @var array<CompilerPassInterface> */
    private array $compilerPasses;

    public function __construct(CompilerPassInterface ...$compilerPasses)
    {
        $this->compilerPasses = $compilerPasses;
    }

    public function addCompilerPass(CompilerPassInterface $pass): void
    {
        $this->compilerPasses[] = $pass;
    }

    /** @return array<CompilerPassInterface> */
    public function getCompilerPasses(): array
    {
        return $this->compilerPasses;
    }
}
