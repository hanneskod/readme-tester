<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

class OutputExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testNoMatch()
    {
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $this->assertInstanceOf(
            Failure::CLASS,
            $expectation->validate(new Result('', 'bar'))
        );
    }

    public function testMatch()
    {
        $expectation = new OutputExpectation(new Regexp('/foo/'));
        $this->assertInstanceOf(
            Success::CLASS,
            $expectation->validate(new Result('', 'foo'))
        );
    }
}
