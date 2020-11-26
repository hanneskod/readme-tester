<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;

final class ParsingCompiler implements CompilerInterface
{
    private ParserInterface $parser;
    private TemplateRenderer $renderer;

    public function __construct(ParserInterface $parser, TemplateRenderer $renderer)
    {
        $this->parser = $parser;
        $this->renderer = $renderer;
    }

    public function compile(iterable $inputs): ExampleStoreInterface
    {
        $globalStore = new CombinedExampleStore;

        foreach ($inputs as $input) {
            $template = $this->parser->parseContent($input->getContents());

            $template->setDefaultNamespace($input->getDefaultNamespace());

            $globalStore->addExampleStore($this->renderer->render($template));
        }

        return $globalStore;
    }
}
