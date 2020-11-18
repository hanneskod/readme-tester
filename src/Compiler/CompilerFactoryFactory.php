<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Markdown;

final class CompilerFactoryFactory
{
    const INPUT_MARKDOWN = 'markdown';

    public function createCompilerFactory(string $id): CompilerFactoryInterface
    {
        switch (true) {
            case $id == self::INPUT_MARKDOWN:
                return new Markdown\CompilerFactory;
        }

        // TODO create from classname

        throw new \RuntimeException("Unknown input format: $id");
    }
}
