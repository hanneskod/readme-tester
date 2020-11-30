<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input\Markdown;

use hanneskod\readmetester\Compiler\CodeBlockImportingPass;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\MultipassCompiler;
use hanneskod\readmetester\Compiler\TransformationPass;
use hanneskod\readmetester\Compiler\UniqueNamePass;
use hanneskod\readmetester\Input\ParsingCompiler;

final class MarkdownCompilerFactory implements CompilerFactoryInterface
{
    public function createCompiler(): CompilerInterface
    {
        return new MultipassCompiler(
            new ParsingCompiler(new Parser),
            [
                new TransformationPass,
                new UniqueNamePass,
                new CodeBlockImportingPass,
            ]
        );
    }
}
