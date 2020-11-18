<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;

final class Compiler implements CompilerInterface
{
    private Parser $parser;
    private TemplateRenderer $renderer;

    public function __construct(Parser $parser, TemplateRenderer $renderer)
    {
        $this->parser = $parser;
        $this->renderer = $renderer;
    }

    public function compile(iterable $inputs): ExampleStoreInterface
    {
        $globalStore = new CombinedExampleStore;

        foreach ($inputs as $input) {
            /** @var Template */
            $template = $this->parser->parse($input->getContents());

            $template->setDefaultNamespace($input->getDefaultNamespace());

            $globalStore->addExampleStore($this->renderer->render($template));
        }

        return $globalStore;
    }
}
