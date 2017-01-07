<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\ReadmeTester;

class AssertReadme
{
    /**
     * @var \PHPUnit_Framework_TestCase
     */
    private $testCase;

    /**
     * @var ReadmeTester
     */
    private $tester;

    public function __construct(\PHPUnit_Framework_TestCase $testCase, ReadmeTester $tester = null)
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
                    new \PHPUnit_Framework_AssertionFailedError("Example $example: {$returnObj->getMessage()}"),
                    0.0
                );
            }
        }
    }
}
