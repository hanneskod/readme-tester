<?php

namespace hanneskod\readmetester\PHPUnit;

use hanneskod\readmetester;

class ReadmeTestCase extends \PHPUnit_Framework_TestCase
{
    protected function getFormatFactory()
    {
        return new readmetester\Format\FormatFactory;
    }

    public function assertReadme($filename, $formatIdentifier = '')
    {
        $this->addToAssertionCount(1);

        $file = new \SplFileObject($filename);

        if (!$formatIdentifier) {
            $formatIdentifier = $file->getExtension();
        }

        $format = $this->getFormatFactory()->createFormat($formatIdentifier);

        $tester = new readmetester\ReadmeTester;
        $result = $this->getTestResultObject();

        foreach ($tester->test($file, $format) as $line) {
            $result->addFailure($this, new \PHPUnit_Framework_AssertionFailedError($line), 0.0);
        }
    }
}
