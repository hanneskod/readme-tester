<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Config\Suite;
use hanneskod\readmetester\Compiler\Pass\FilterPass;
use hanneskod\readmetester\Compiler\StdinInput;
use hanneskod\readmetester\Example\ExampleStoreInterface;

final class ExampleProvider implements ExampleProviderInterface
{
    private ?StdinInput $stdin = null;

    public function __construct(
        private Compiler\CompilerFactoryFactory $compilerFactoryFactory,
        private Compiler\Pass\DefaultCompilerPasses $defaultPasses,
        private FilesystemFacade $filesystemFacade,
    ) {}

    public function getExamplesForSuite(Suite $suite): ExampleStoreInterface
    {
        $prependPasses = [];
        $appendPasses = [];

        // Setup filtering

        if ($filter = $suite->getFilter()) {
            $appendPasses[] = new FilterPass(
                new Utils\Regexp('/' . preg_quote($filter, '/') . '/i')
            );
        }

        // Create inputs

        $inputs = match($suite->readFromStdin()) {
            true => [$this->getStdin()],
            false => $this->filesystemFacade->getFilesystemInput(
                '.',
                $suite->getIncludePaths(),
                $suite->getFileExtensions(),
                $suite->getExcludePaths()
            ),
        };

        // Create compiler and compile

        return $this->compilerFactoryFactory
            ->createCompilerFactory($suite->getInputLanguage())
            ->createCompiler([...$prependPasses, ...$this->defaultPasses->getPasses(), ...$appendPasses])
            ->compile($inputs);
    }

    private function getStdin(): StdinInput
    {
        if (!isset($this->stdin)) {
            $this->stdin = new StdinInput();
        }

        return $this->stdin;
    }
}
