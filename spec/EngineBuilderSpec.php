<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\EngineBuilder;
use hanneskod\readmetester\Engine;
use hanneskod\readmetester\Runner\RunnerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EngineBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EngineBuilder::class);
    }

    function it_fails_if_no_runner_is_set()
    {
        $this->shouldThrow(\LogicException::class)->duringBuildEngine();
    }

    function it_builds_engine(RunnerInterface $runner)
    {
        $this->setRunner($runner);
        $this->buildEngine()->shouldHaveType(Engine::class);
    }
}
