<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\ErrorOutcome;
use hanneskod\readmetester\Runner\OutputOutcome;
use hanneskod\readmetester\Runner\VoidOutcome;
use hanneskod\readmetester\Example\ArrayExampleStore;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\NameObj;

trait RunnerSpecTrait
{
    function it_is_a_runner()
    {
        $this->shouldHaveType(RunnerInterface::class);
    }

    function an_example(string $code): ExampleObj
    {
        return new ExampleObj(
            new NameObj('', ''),
            new CodeBlock($code)
        );
    }

    function it_returns_void_on_no_outcome()
    {
        $this->run(new ArrayExampleStore([$this->an_example('$a = 1 + 2;')]))
            ->shouldReturnOutcomeInstancesOf([VoidOutcome::class]);
    }

    function it_returns_output()
    {
        $this->run(new ArrayExampleStore([$this->an_example('echo "foo";')]))
            ->shouldReturnOutcomeInstancesOf([OutputOutcome::class]);
    }

    function it_returns_error_on_exception()
    {
        $this->run(new ArrayExampleStore([$this->an_example('throw new Exception;')]))
            ->shouldReturnOutcomeInstancesOf([ErrorOutcome::class]);
    }

    function it_returns_error_on_trigger_error()
    {
        $this->run(new ArrayExampleStore([$this->an_example('trigger_error("ERROR");')]))
            ->shouldReturnOutcomeInstancesOf([ErrorOutcome::class]);
    }

    function it_returns_error_on_fatal_error()
    {
        $this->run(new ArrayExampleStore([$this->an_example('this_function_does_not_exist();')]))
            ->shouldReturnOutcomeInstancesOf([ErrorOutcome::class]);
    }

    function it_can_be_namespaced()
    {
        $this->run(new ArrayExampleStore([$this->an_example('namespace test;')]))
            ->shouldReturnOutcomeInstancesOf([VoidOutcome::class]);
    }

    function it_can_be_bootstraped()
    {
        $this->setBootstrap(__FILE__);

        $example = $this->an_example('new \spec\hanneskod\readmetester\Runner\ClassLoadedFromBootstrap;');

        $this->run(new ArrayExampleStore([$example]))
            ->shouldReturnOutcomeInstancesOf([VoidOutcome::class]);
    }

    function getMatchers(): array
    {
        return [
            'returnOutcomeInstancesOf' => function (iterable $outcomes, array $expectedClassnames) {
                if ($outcomes instanceof \Traversable) {
                    $outcomes = iterator_to_array($outcomes, false);
                }

                $classnames = array_map(
                    fn($outcome) => $outcome::class,
                    $outcomes
                );

                if ($classnames == $expectedClassnames) {
                    return true;
                }

                throw new \Exception(
                    sprintf(
                        'Expected outcome instances [%s], found [%s]',
                        implode(', ', $expectedClassnames),
                        implode(', ', $classnames),
                    )
                );
            },
        ];
    }
}

// phpcs:disable

class ClassLoadedFromBootstrap
{
}
