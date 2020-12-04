<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\ErrorOutcome;
use hanneskod\readmetester\Runner\OutputOutcome;
use hanneskod\readmetester\Runner\VoidOutcome;
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
        $this->run($this->an_example('$a = 1 + 2;'))->shouldHaveType(VoidOutcome::class);
    }

    function it_returns_output()
    {
        $example = $this->an_example('echo "foo";');
        $this->run($example)->shouldBeLike(new OutputOutcome($example, 'foo'));
    }

    function it_returns_error_on_exception()
    {
        $this->run($this->an_example('throw new Exception;'))->shouldHaveType(ErrorOutcome::class);
    }

    function it_returns_error_on_trigger_error()
    {
        $this->run($this->an_example('trigger_error("ERROR");'))->shouldHaveType(ErrorOutcome::class);
    }

    function it_returns_error_on_fatal_error()
    {
        $this->run($this->an_example('this_function_does_not_exist();'))->shouldHaveType(ErrorOutcome::class);
    }

    function it_can_be_namespaced()
    {
        $this->run($this->an_example('namespace test;'))->shouldHaveType(VoidOutcome::class);
    }

    function it_can_be_bootstraped()
    {
        $this->setBootstrap(__FILE__);
        $this->run($this->an_example('new \spec\hanneskod\readmetester\Runner\ClassLoadedFromBootstrap;'))
            ->shouldHaveType(VoidOutcome::class);
    }
}

// phpcs:disable

class ClassLoadedFromBootstrap
{
}
