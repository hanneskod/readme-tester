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

    public function appendPass(CompilerPassInterface $pass): void
    {
        $this->compilerPasses[] = $pass;
    }

    public function prependPass(CompilerPassInterface $pass): void
    {
        array_unshift($this->compilerPasses, $pass);
    }

    /** @return array<CompilerPassInterface> */
    public function getPasses(): array
    {
        return $this->compilerPasses;
    }
}
