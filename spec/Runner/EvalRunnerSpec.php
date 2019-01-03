<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\EvalRunner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EvalRunnerSpec extends ObjectBehavior
{
    use RunnerSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType(EvalRunner::CLASS);
    }
}
