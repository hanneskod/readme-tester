<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Compiler\Pass;

use hanneskod\readmetester\Compiler\Pass\CodeBlockImportingPass;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\NameObj;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CodeBlockImportingPassSpec extends ObjectBehavior
{
    function an_import(ExampleObj $imported): string
    {
        return sprintf(
            "// <import %s>\n%s// </import>\n",
            $imported->getName()->getFullName(),
            $imported->getCodeBlock()->getCode()
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CodeBlockImportingPass::class);
    }

    function it_is_a_compiler_pass()
    {
        $this->shouldHaveType(CompilerPassInterface::class);
    }

    function it_builds_simple_examples()
    {
        $exampleName = NameObj::fromString('example');

        $example = new ExampleObj($exampleName, new CodeBlock('example-code'));

        $this->process(new ArrayExampleStore([$example]))->shouldReturnExampleWithCode(
            $exampleName,
            'example-code'
        );
    }

    function it_throws_on_missing_import()
    {
        $exampleName = NameObj::fromString('example');

        $example = (new ExampleObj($exampleName, new CodeBlock('')))
            ->withImport(NameObj::fromString('does-not-exist'));

        $this->shouldThrow(\RuntimeException::class)->duringProcess(new ArrayExampleStore([$example]));
    }

    function it_adds_import()
    {
        $exampleName = NameObj::fromString('example');
        $importName = NameObj::fromString('import');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withImport($importName);

        $import = new ExampleObj($importName, new CodeBlock('imported-code'));

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode(
            $exampleName,
            $this->an_import($import) . 'example-code'
        );
    }

    function it_adds_context()
    {
        $exampleName = NameObj::fromString('example');

        $example = new ExampleObj($exampleName, new CodeBlock('example-code'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('context-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $context]))->shouldReturnExampleWithCode(
            $exampleName,
            $this->an_import($context) . 'example-code'
        );
    }

    function it_adds_context_and_import()
    {
        $exampleName = NameObj::fromString('example');
        $importName = NameObj::fromString('import');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withImport($importName);

        $import = new ExampleObj($importName, new CodeBlock('imported-code'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('context-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $import, $context]))
            ->shouldReturnExampleWithCode(
                $exampleName,
                $this->an_import($context) . $this->an_import($import) . 'example-code'
            );
    }

    function it_does_not_add_context_to_self()
    {
        $exampleName = NameObj::fromString('example');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example]))->shouldReturnExampleWithCode(
            $exampleName,
            'example-code'
        );
    }

    function it_adds_import_that_is_also_a_context_only_once()
    {
        $exampleName = NameObj::fromString('example');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withImport(NameObj::fromString('import'));

        $import = (new ExampleObj(NameObj::fromString('import'), new CodeBlock('imported-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode(
            $exampleName,
            $this->an_import($import) . 'example-code'
        );
    }

    function it_puts_contexts_before_imports()
    {
        $exampleName = NameObj::fromString('example');
        $importContextName = NameObj::fromString('import-context');
        $importName = NameObj::fromString('import');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withImport($importContextName)
            ->withImport($importName);

        $importContext = (new ExampleObj($importContextName, new CodeBlock('import-context-code')))
            ->withIsContext(true);

        $import = new ExampleObj($importName, new CodeBlock('import-code'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('context-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $importContext, $import, $context]))
            ->shouldReturnExampleWithCode(
                $exampleName,
                $this->an_import($importContext)
                    . $this->an_import($context)
                    . $this->an_import($import)
                    . 'example-code'
            );
    }

    function it_ignores_contexts_in_other_namespaces()
    {
        $exampleName = NameObj::fromString('foo:example');

        $example = new ExampleObj($exampleName, new CodeBlock('example-code'));

        $context = (new ExampleObj(NameObj::fromString('bar:context'), new CodeBlock('imported-code')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $context]))->shouldReturnExampleWithCode(
            $exampleName,
            'example-code'
        );
    }

    function it_adds_namespaced_import()
    {
        $exampleName = NameObj::fromString('foo:example');
        $importName = NameObj::fromString('bar:import');

        $example = (new ExampleObj($exampleName, new CodeBlock('example-code')))
            ->withImport($importName);

        $import = new ExampleObj($importName, new CodeBlock('imported-code'));

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode(
            $exampleName,
            $this->an_import($import) . 'example-code'
        );
    }

    public function getMatchers(): array
    {
        return [
            'returnExampleWithCode' => function (ExampleStoreInterface $store, NameObj $name, string $code) {
                foreach ($store->getExamples() as $example) {
                    if ($example->getName()->getFullName() === $name->getFullName()) {
                        return $example->getCodeBlock()->getCode() == $code;
                    }
                }

                return false;
            }
        ];
    }
}
