<?php

declare(strict_types = 1);

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
        $example = new ExampleObj(NameObj::fromString('example'), new CodeBlock('E'));
        $this->process(new ArrayExampleStore([$example]))->shouldReturnExampleWithCode('example', 'E');
    }

    function it_throws_on_missing_import()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('does-not-exist'));

        $this->shouldThrow(\RuntimeException::class)->duringProcess(new ArrayExampleStore([$example]));
    }

    function it_adds_import()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('import'));

        $import = new ExampleObj(NameObj::fromString('import'), new CodeBlock('I'));

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode('example', 'IE');
    }

    function it_adds_context()
    {
        $example = new ExampleObj(NameObj::fromString('example'), new CodeBlock('E'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('C')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $context]))->shouldReturnExampleWithCode('example', 'CE');
    }

    function it_adds_context_and_import()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('import'));

        $import = new ExampleObj(NameObj::fromString('import'), new CodeBlock('I'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('C')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $import, $context]))
            ->shouldReturnExampleWithCode('example', 'CIE');
    }

    function it_does_not_add_context_to_self()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example]))->shouldReturnExampleWithCode('example', 'E');
    }

    function it_adds_import_that_is_also_a_context_only_once()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('import'));

        $import = (new ExampleObj(NameObj::fromString('import'), new CodeBlock('I')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode('example', 'IE');
    }

    function it_puts_contexts_before_imports()
    {
        $example = (new ExampleObj(NameObj::fromString('example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('import1'))
            ->withImport(NameObj::fromString('import2'));

        $import1 = (new ExampleObj(NameObj::fromString('import1'), new CodeBlock('I1')))
            ->withIsContext(true);

        $import2 = new ExampleObj(NameObj::fromString('import2'), new CodeBlock('I2'));

        $context = (new ExampleObj(NameObj::fromString('context'), new CodeBlock('C')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $import1, $import2, $context]))
            ->shouldReturnExampleWithCode('example', 'I1CI2E');
    }

    function it_ignores_contexts_in_other_namespaces()
    {
        $example = new ExampleObj(NameObj::fromString('foo:example'), new CodeBlock('E'));

        $context = (new ExampleObj(NameObj::fromString('bar:context'), new CodeBlock('C')))
            ->withIsContext(true);

        $this->process(new ArrayExampleStore([$example, $context]))->shouldReturnExampleWithCode('foo:example', 'E');
    }

    function it_adds_namespaced_import()
    {
        $example = (new ExampleObj(NameObj::fromString('foo:example'), new CodeBlock('E')))
            ->withImport(NameObj::fromString('bar:import'));

        $import = new ExampleObj(NameObj::fromString('bar:import'), new CodeBlock('I'));

        $this->process(new ArrayExampleStore([$example, $import]))->shouldReturnExampleWithCode('foo:example', 'IE');
    }

    public function getMatchers(): array
    {
        return [
            'returnExampleWithCode' => function (ExampleStoreInterface $store, string $name, string $code) {
                foreach ($store->getExamples() as $example) {
                    if ($example->getName()->getFullName() === $name) {
                        return $example->getCodeBlock()->getCode() === $code;
                    }
                }

                return false;
            }
        ];
    }
}
