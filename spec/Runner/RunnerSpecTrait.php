<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\RunnerInterface;
use hanneskod\readmetester\Runner\ErrorOutcome;
use hanneskod\readmetester\Runner\OutputOutcome;
use hanneskod\readmetester\Runner\VoidOutcome;
use hanneskod\readmetester\Utils\CodeBlock;

trait RunnerSpecTrait
{
    function it_is_a_runner()
    {
        $this->shouldHaveType(RunnerInterface::CLASS);
    }

    function it_returns_void_on_no_outcome()
    {
        $this->run(new CodeBlock('$a = 1 + 2;'))->shouldHaveType(VoidOutcome::CLASS);
    }

    function it_returns_output()
    {
        $this->run(new CodeBlock('echo "foo";'))->shouldBeLike(new OutputOutcome('foo'));
    }

    function it_returns_error_on_exception()
    {
        $this->run(new CodeBlock('throw new Exception;'))->shouldHaveType(ErrorOutcome::CLASS);
    }

    function it_returns_error_on_trigger_error()
    {
        $this->run(new CodeBlock('trigger_error("ERROR");'))->shouldHaveType(ErrorOutcome::CLASS);
    }

    function it_returns_error_on_fatal_error()
    {
        $this->run(new CodeBlock('this_function_does_not_exist();'))->shouldHaveType(ErrorOutcome::CLASS);
    }

    function it_can_be_namespaced()
    {
        $this->run(new CodeBlock('namespace test;'))->shouldHaveType(VoidOutcome::CLASS);
    }

    function it_throws_on_invalid_bootstrap()
    {
        $this->beConstructedWith('this-filename-does-not-exist');
        $this->shouldThrow(\RuntimeException::CLASS)->duringInstantiation();
    }

    function it_can_be_bootstraped()
    {
        $this->beConstructedWith(__DIR__ . '/Bootstrap.php');
        $this->run(new CodeBlock('new \spec\hanneskod\readmetester\Runner\Bootstrap;'))
            ->shouldHaveType(VoidOutcome::CLASS);
    }
}
