<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;

final class ParsingCompiler implements CompilerInterface
{
    public function __construct(
        private ParserInterface $parser,
    ) {}

    public function compile(iterable $inputs): ExampleStoreInterface
    {
        $globalStore = new CombinedExampleStore;

        foreach ($inputs as $input) {
            $template = $this->parser->parseContent($input->getContents());

            $template->setDefaultNamespace($input->getDefaultNamespace());

            $globalStore->addExampleStore($template->render());
        }

        return $globalStore;
    }
}
