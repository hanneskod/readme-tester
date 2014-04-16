<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Expectation;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class OutputRegexExpectation extends BaseExpectation
{
    public function start()
    {
        ob_start();
    }

    public function evaluate($returnValue)
    {
        $this->testCase->assertRegExp(
            $this->string,
            ob_get_clean(),
            "In example <$this->exampleName>."
        );
    }
}
