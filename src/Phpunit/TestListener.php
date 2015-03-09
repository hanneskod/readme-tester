<?php

namespace hanneskod\readmetester\Phpunit;

use PHPUnit_Framework_BaseTestListener;
use hanneskod\readmetester\ReadmeTester;
use hanneskod\readmetester\FileInfo;

/**
 * Integrate validation with phpunit testsuite
 */
class TestListener extends PHPUnit_Framework_BaseTestListener
{
    /**
     * @var String[] Names of files to validate
     */
    private $filenames;

    /**
     * Load names of files to validate
     *
     * @param string $filename...
     */
    public function __construct()
    {
        $this->filenames = func_get_args();
    }

    /**
     * Perform testing at destruct
     */
    public function __destruct()
    {
        $tester = new ReadmeTester;
        foreach ($this->filenames as $filename) {
            print("\nTesting examples in $filename\n ");
            print(implode("\n ", $tester->test(new FileInfo($filename))) . "\n");
        }
    }
}
