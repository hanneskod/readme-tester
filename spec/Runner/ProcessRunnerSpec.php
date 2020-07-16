<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Runner\VoidOutcome;
use hanneskod\readmetester\Utils\CodeBlock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessRunnerSpec extends ObjectBehavior
{
    use RunnerSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType(ProcessRunner::class);
    }

    function it_runs_examples_in_isolation()
    {
        $this->run($this->an_example('class Foo {}'))->shouldHaveType(VoidOutcome::class);
        $this->run($this->an_example('class Foo {}'))->shouldHaveType(VoidOutcome::class);
    }
}
