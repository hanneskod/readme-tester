<?php

declare(strict_types=1);

namespace hanneskod\readmetester\InputLanguage\Markdown;

use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\MultipassCompiler;
use hanneskod\readmetester\InputLanguage\ParsingCompiler;

final class MarkdownCompilerFactory implements CompilerFactoryInterface
{
    public function createCompiler(array $compilerPasses = []): CompilerInterface
    {
        return new MultipassCompiler(
            new ParsingCompiler(new Parser()),
            $compilerPasses
        );
    }
}
