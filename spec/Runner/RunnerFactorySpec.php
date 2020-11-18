<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\RunnerFactory;
use hanneskod\readmetester\Runner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RunnerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RunnerFactory::class);
    }

    function it_creates_eval_runner()
    {
        $this->createRunner(RunnerFactory::RUNNER_EVAL)
            ->shouldHaveType(Runner\EvalRunner::class);
    }

    function it_creates_process_runner()
    {
        $this->createRunner(RunnerFactory::RUNNER_PROCESS)
            ->shouldHaveType(Runner\ProcessRunner::class);
    }

    function it_throws_on_invalid_id()
    {
        $this->shouldThrow(\RuntimeException::class)->duringCreateRunner('does-not-exist');
    }

    function it_creates_from_classname()
    {
        $this->createRunner(Runner\EvalRunner::class)
            ->shouldHaveType(Runner\EvalRunner::class);
    }

    function it_throws_on_invalid_class()
    {
        $this->shouldThrow(\RuntimeException::class)->duringCreateRunner(__CLASS__);
    }
}
