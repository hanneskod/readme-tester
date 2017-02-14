<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\SourceFileIterator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;

class AssertReadme
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var ReadmeTester
     */
    private $tester;

    public function __construct(TestCase $testCase, ReadmeTester $tester = null)
    {
        $this->testCase = $testCase;
        $this->tester = $tester ?: new ReadmeTester;
    }

    public function assertReadme(string $source)
    {
        $testResult = $this->testCase->getTestResultObject();

        foreach (new SourceFileIterator($source) as $filename => $contents) {
            foreach ($this->tester->test($contents) as $example => $returnObj) {
                $this->testCase->addToAssertionCount(1);
                if ($returnObj->isFailure()) {
                    $testResult->addFailure(
                        $this->testCase,
                        new AssertionFailedError("Example $example in $filename: {$returnObj->getMessage()}"),
                        0.0
                    );
                }
            }
        }
    }
}
