<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Attribute\Isolate;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;

use function Amp\Promise\wait;
use function Amp\ParallelFunctions\parallelMap;

final class ParallelRunner implements RunnerInterface
{
    private string $bootstrap = '';

    public function setBootstrap(string $filename): void
    {
        $this->bootstrap = $filename;
    }

    public function run(ExampleStoreInterface $exampleStore): iterable
    {
        $examples = $exampleStore->getExamples();

        if ($examples instanceof \Traversable) {
            $examples = iterator_to_array($examples, false);
        }

        // @phpstan-ignore-next-line
        return wait(
            parallelMap(
                $examples,
                function (ExampleObj $example): OutcomeInterface {
                    $runner = new EvalRunner();
                    $runner->setBootstrap($this->bootstrap);
                    return $runner->runExample($example);
                }
            )
        );
    }
}
