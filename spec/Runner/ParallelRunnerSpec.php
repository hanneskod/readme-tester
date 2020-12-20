<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\ParallelRunner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParallelRunnerSpec extends ObjectBehavior
{
    use RunnerSpecTrait;

    private $oldErrorReporting = E_ALL;

    function let()
    {
        $this->oldErrorReporting = error_reporting(0);
    }

    function letGo()
    {
        error_reporting($this->oldErrorReporting);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ParallelRunner::class);
    }
}
