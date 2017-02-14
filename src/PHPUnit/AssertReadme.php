<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\ReadmeTester;
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

    public function assertReadme($filename)
    {
        $result = $this->testCase->getTestResultObject();

        foreach ($this->tester->test(file_get_contents($filename)) as $example => $returnObj) {
            $this->testCase->addToAssertionCount(1);
            if ($returnObj->isFailure()) {
                $result->addFailure(
                    $this->testCase,
                    new AssertionFailedError("Example $example: {$returnObj->getMessage()}"),
                    0.0
                );
            }
        }
    }
}
