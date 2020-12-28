<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Runner;

use hanneskod\readmetester\Runner\EvalRunner;
use hanneskod\readmetester\Runner\SkippedOutcome;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use hanneskod\readmetester\Utils\CodeBlock;
use hanneskod\readmetester\Utils\NameObj;
use hanneskod\readmetester\Attribute\Isolate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EvalRunnerSpec extends ObjectBehavior
{
    use RunnerSpecTrait;

    function it_is_initializable()
    {
        $this->shouldHaveType(EvalRunner::class);
    }

    function it_ignores_examples_that_must_run_in_isolation(ExampleStoreInterface $store)
    {
        $exampleToSkip = new ExampleObj(
            new NameObj('', ''),
            new CodeBlock(''),
            [new Isolate()]
        );

        $store->getExamples()->willReturn([$exampleToSkip]);

        $this->run($store)->shouldReturnOutcomeInstancesOf([SkippedOutcome::class]);
    }
}
