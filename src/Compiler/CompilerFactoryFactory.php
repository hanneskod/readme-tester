<?php

// phpcs:disable Squiz.WhiteSpace.ScopeClosingBrace

declare(strict_types=1);

namespace hanneskod\readmetester\Compiler;

use hanneskod\readmetester\Config\Configs;
use hanneskod\readmetester\Exception\InstantiatorException;
use hanneskod\readmetester\Exception\InvalidInputLanguageException;
use hanneskod\readmetester\Utils\Instantiator;

class CompilerFactoryFactory
{
    public function __construct(
        private Instantiator $instantiator,
    ) {}

    public function createCompilerFactory(string $id): CompilerFactoryInterface
    {
        try {
            $factory = $this->instantiator->getNewObject(
                Configs::expand(Configs::INPUT_ID, $id),
            );
        } catch (InstantiatorException $exception) {
            throw new InvalidInputLanguageException("Invalid input language $id: {$exception->getMessage()}");
        }

        if (!$factory instanceof CompilerFactoryInterface) {
            throw new InvalidInputLanguageException(
                "Invalid input language $id: Class does not implement CompilerFactoryInterface"
            );
        }

        return $factory;
    }
}
