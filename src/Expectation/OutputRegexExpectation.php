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
class OutputRegexExpectation implements ExpectationInterface
{
    private $regex, $exampleName, $testCase;

    public function __construct($regex, $exampleName, TestCase $testCase)
    {
        $this->regex = $regex;
        $this->exampleName = $exampleName;
        $this->testCase = $testCase;
    }

    public function start()
    {
        ob_start();
    }

    public function evaluate()
    {
        $this->testCase->assertRegExp(
            $this->regex,
            ob_get_clean(),
            "In example <$this->exampleName>."
        );
    }
}
