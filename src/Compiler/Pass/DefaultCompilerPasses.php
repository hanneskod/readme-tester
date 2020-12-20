<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\CompilerPassInterface;

class DefaultCompilerPasses
{
    /** @var array<CompilerPassInterface> */
    private array $passes;

    public function __construct(CompilerPassInterface ...$passes)
    {
        $this->passes = $passes;
    }

    /** @return array<CompilerPassInterface> */
    public function getPasses(): array
    {
        return $this->passes;
    }
}
