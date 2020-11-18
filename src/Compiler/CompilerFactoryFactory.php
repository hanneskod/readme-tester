<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Markdown;
use hanneskod\readmetester\Utils\Instantiator;

final class CompilerFactoryFactory
{
    const INPUT_MARKDOWN = 'markdown';

    public function createCompilerFactory(string $id): CompilerFactoryInterface
    {
        switch (true) {
            case $id == self::INPUT_MARKDOWN:
                return new Markdown\CompilerFactory;
        }

        $factory = Instantiator::instantiate($id);

        if (!$factory instanceof CompilerFactoryInterface) {
            throw new \RuntimeException("$id does no implement CompilerFactoryInterface");
        }

        return $factory;
    }
}
