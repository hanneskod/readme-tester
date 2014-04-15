<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Expectation;

use hanneskod\exemplify\ExpectationInterface;
use hanneskod\exemplify\TestCase;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class OutputStringExpectation implements ExpectationInterface
{
    private $expectedStr, $exampleName, $testCase;

    public function __construct($expectedStr, $exampleName, TestCase $testCase)
    {
        $this->expectedStr = $expectedStr;
        $this->exampleName = $exampleName;
        $this->testCase = $testCase;
    }

    public function start()
    {
        ob_start();
    }

    public function evaluate()
    {
        $this->testCase->assertEquals(
            $this->expectedStr,
            ob_get_clean(),
            "In example <$this->exampleName>."
        );
    }
}
