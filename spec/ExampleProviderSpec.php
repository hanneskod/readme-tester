<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\ExampleProvider;
use hanneskod\readmetester\ExampleProviderInterface;
use hanneskod\readmetester\FilesystemFacade;
use hanneskod\readmetester\Compiler\CompilerFactoryFactory;
use hanneskod\readmetester\Compiler\CompilerFactoryInterface;
use hanneskod\readmetester\Compiler\CompilerInterface;
use hanneskod\readmetester\Compiler\CompilerPassInterface;
use hanneskod\readmetester\Compiler\InputInterface;
use hanneskod\readmetester\Compiler\StdinInput;
use hanneskod\readmetester\Compiler\Pass\DefaultCompilerPasses;
use hanneskod\readmetester\Compiler\Pass\FilterPass;
use hanneskod\readmetester\Config\Suite;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\Regexp;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExampleProviderSpec extends ObjectBehavior
{
    function let(
        CompilerFactoryFactory $compilerFactoryFactory,
        DefaultCompilerPasses $defaultPasses,
        FilesystemFacade $filesystemFacade,
    ) {
        $this->beConstructedWith($compilerFactoryFactory, $defaultPasses, $filesystemFacade);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ExampleProvider::class);
    }

    function it_is_an_example_provider()
    {
        $this->shouldHaveType(ExampleProviderInterface::class);
    }

    function it_provides_examples(
        $compilerFactoryFactory,
        $defaultPasses,
        $filesystemFacade,
        Suite $suite,
        CompilerFactoryInterface $compilerFactory,
        CompilerPassInterface $pass,
        CompilerInterface $compiler,
        InputInterface $input,
        ExampleStoreInterface $examples,
    ) {
        $suite->getFilter()->willReturn('');

        $suite->getInputLanguage()->willReturn('input-lang');
        $compilerFactoryFactory->createCompilerFactory('input-lang')->willReturn($compilerFactory)->shouldBeCalled();

        $defaultPasses->getPasses()->willReturn([$pass]);
        $compilerFactory->createCompiler([$pass])->willReturn($compiler)->shouldBeCalled();

        $suite->readFromStdin()->willReturn(false);
        $suite->getIncludePaths()->willReturn(['include']);
        $suite->getExcludePaths()->willReturn(['exclude']);
        $suite->getFileExtensions()->willReturn(['extension']);
        $filesystemFacade->getFilesystemInput('.', ['include'], ['extension'], ['exclude'])
            ->willReturn([$input])
            ->shouldBeCalled();

        $compiler->compile([$input])->willReturn($examples)->shouldBeCalled();

        $this->getExamplesForSuite($suite)->shouldReturn($examples);
    }

    function it_provides_examples_from_stdin(
        $compilerFactoryFactory,
        $defaultPasses,
        Suite $suite,
        CompilerFactoryInterface $compilerFactory,
        CompilerPassInterface $pass,
        CompilerInterface $compiler,
        ExampleStoreInterface $examples,
    ) {
        $suite->getFilter()->willReturn('');

        $suite->getInputLanguage()->willReturn('input-lang');
        $compilerFactoryFactory->createCompilerFactory('input-lang')->willReturn($compilerFactory)->shouldBeCalled();

        $defaultPasses->getPasses()->willReturn([$pass]);
        $compilerFactory->createCompiler([$pass])->willReturn($compiler)->shouldBeCalled();

        $suite->readFromStdin()->willReturn(true);
        $compiler->compile([new StdinInput])->willReturn($examples)->shouldBeCalled();

        $this->getExamplesForSuite($suite)->shouldReturn($examples);
    }

    function it_loades_filter(
        $compilerFactoryFactory,
        $defaultPasses,
        Suite $suite,
        CompilerFactoryInterface $compilerFactory,
        CompilerPassInterface $pass,
        CompilerInterface $compiler,
        InputInterface $input,
        ExampleStoreInterface $examples,
    ) {
        $suite->getInputLanguage()->willReturn('i');
        $compilerFactoryFactory->createCompilerFactory('i')->willReturn($compilerFactory);

        $defaultPasses->getPasses()->willReturn([$pass]);

        $suite->getFilter()->willReturn('FILTER');

        $compilerFactory->createCompiler([$pass, new FilterPass(new Regexp('/FILTER/'))])
            ->willReturn($compiler)
            ->shouldBeCalled();

        $suite->readFromStdin()->willReturn(true);
        $compiler->compile([new StdinInput])->willReturn($examples);
        $this->getExamplesForSuite($suite)->shouldReturn($examples);
    }
}
