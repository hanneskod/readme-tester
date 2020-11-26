<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\DependencyInjection;

final class CompilerFactoryFactory
{
    use DependencyInjection\InstantiatorProperty;

    public function createCompilerFactory(string $id): CompilerFactoryInterface
    {
        $factory = $this->instantiator->getNewObject(
            Configs::expand(Configs::INPUT_ID, $id),
        );

        if (!$factory instanceof CompilerFactoryInterface) {
            throw new \RuntimeException("$id does no implement CompilerFactoryInterface");
        }

        return $factory;
    }
}
