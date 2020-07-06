<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Compiler\CodeBlockImportingPass;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\MultipassCompiler;
use hanneskod\readmetester\Compiler\TransformationPass;
use hanneskod\readmetester\Compiler\UniqueNamePass;

final class CompilerFactory implements CompilerFactoryInterface
{
    public function createCompiler(): CompilerInterface
    {
        return new MultipassCompiler(
            new Compiler(new Parser, new TemplateRenderer),
            [
                new TransformationPass,
                new UniqueNamePass,
                new CodeBlockImportingPass,
            ]
        );
    }
}
