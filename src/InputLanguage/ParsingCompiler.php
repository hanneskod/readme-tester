<?php

declare(strict_types=1);

namespace hanneskod\readmetester\InputLanguage;

use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Example\CombinedExampleStore;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Exception\InvalidInputException;
use hanneskod\readmetester\Exception\InvalidPhpCodeException;

final class ParsingCompiler implements CompilerInterface
{
    public function __construct(
        private ParserInterface $parser,
    ) {}

    public function compile(iterable $inputs): ExampleStoreInterface
    {
        $globalStore = new CombinedExampleStore();

        foreach ($inputs as $input) {
            try {
                $template = $this->parser->parseContent($input->getContents());

                $template->setDefaultNamespace($input->getName());

                $globalStore->addExampleStore($template->render());
            } catch (InvalidPhpCodeException $exception) {
                throw new InvalidInputException($exception->getMessage(), $input, $exception->getPhpCode());
            } catch (\Exception $exception) {
                throw new InvalidInputException($exception->getMessage(), $input, $exception->getMessage());
            }
        }

        return $globalStore;
    }
}
