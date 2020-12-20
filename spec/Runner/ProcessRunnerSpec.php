<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\ProcessRunner;
use hanneskod\readmetester\Runner\VoidOutcome;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProcessRunnerSpec extends ObjectBehavior
{
    use RunnerSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType(ProcessRunner::class);
    }

    function it_runs_examples_in_isolation(ExampleStoreInterface $store)
    {
        $store->getExamples()->willReturn([$this->an_example('class Foo {}')]);

        $this->run($store)->shouldReturnOutcomeInstancesOf([VoidOutcome::class]);

        // Creating the class a second time should not blow up
        $this->run($store)->shouldReturnOutcomeInstancesOf([VoidOutcome::class]);
    }
}
