<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\ListenerInterface;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Expectation\Status;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;

class PhpunitListener implements ListenerInterface
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var string
     */
    private $exampleName;

    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    public function onExample(ExampleInterface $example): void
    {
        $this->exampleName = $example->getName()->getCompleteName();
    }

    public function onIgnoredExample(ExampleInterface $example): void
    {
    }

    public function onExpectation(Status $status): void
    {
        $this->testCase->addToAssertionCount(1);
        if (!$status->isSuccess()) {
            $this->testCase->getTestResultObject()->addFailure(
                $this->testCase,
                new AssertionFailedError("Example {$this->exampleName}: $status"),
                0.0
            );
        }
    }
}
