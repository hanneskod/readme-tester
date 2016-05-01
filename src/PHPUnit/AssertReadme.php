<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\Format\FormatFactory;

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

    /**
     * @var FormatFactory
     */
    private $formatFactory;

    public function __construct(
        \PHPUnit_Framework_TestCase $testCase,
        ReadmeTester $tester = null,
        FormatFactory $formatFactory = null
    ) {
        $this->testCase = $testCase;
        $this->tester = $tester ?: new ReadmeTester;
        $this->formatFactory = $formatFactory ?: new FormatFactory;
    }

    /**
     * Validate code examples in $file
     *
     * @param  \SplFileObject $file
     * @param  string         $formatIdentifier
     * @return void
     */
    public function assertFile(\SplFileObject $file, $formatIdentifier = '')
    {
        $format = $this->formatFactory->createFormat($formatIdentifier ?: $file->getExtension());
        $result = $this->testCase->getTestResultObject();

        foreach ($this->tester->test($file, $format) as $example => $returnObj) {
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

    public function assertReadme($filename, $formatIdentifier = '')
    {
        return $this->assertFile(new \SplFileObject($filename), $formatIdentifier);
    }
}
