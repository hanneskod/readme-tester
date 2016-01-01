<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester;

class ReadmeTestCase extends \PHPUnit_Framework_TestCase
{
    public function assertReadme($filename)
    {
        /*
            TODO TestCommand is more versitile. Here it should be possible to
                : set the format using in identifyer instead of the factory
         */

        $tester = new readmetester\ReadmeTester;
        $this->addToAssertionCount(1);
        $result = $this->getTestResultObject();

        $file = new \SplFileObject($filename);
        $format = (new readmetester\Format\Factory)->createFormat($file);

        foreach ($tester->test($file, $format) as $line) {
            $result->addFailure($this, new \PHPUnit_Framework_AssertionFailedError($line), 0.0);
        }
    }
}
