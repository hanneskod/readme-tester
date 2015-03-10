<?php

namespace hanneskod\readmetester;

class ReadmeTestCase extends \PHPUnit_Framework_TestCase
{
    public function assertReadme($filename)
    {
        $tester = new ReadmeTester;
        $this->addToAssertionCount(1);
        $result = $this->getTestResultObject();

        foreach ($tester->test(new FileInfo($filename)) as $line) {
            $result->addFailure($this, new \PHPUnit_Framework_AssertionFailedError($line), 0.0);
        }
    }
}
