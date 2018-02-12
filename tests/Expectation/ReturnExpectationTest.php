<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\Result;

class ReturnExpectationTest extends \PHPUnit\Framework\TestCase
{
    public function testNoMatch()
    {
        $expectation = new ReturnExpectation(new Regexp('/foo/'));
        $this->assertInstanceOf(
            Failure::CLASS,
            $expectation->validate(new Result('bar', ''))
        );
    }

    public function testMatchOfNonString()
    {
        $this->expectException('UnexpectedValueException');
        $expectation = new ReturnExpectation(new Regexp(''));
        $expectation->validate(new Result([], ''));
    }

    public function matchesProvider()
    {
        return [
            ['/foo/', 'foo'],
            ['1', '1'],
            ['1', 1],
            ['1', true],
            ['/1\.5/', 1.5],
            ['//', null],
            ['/Exception/', new \Exception],
        ];
    }

    /**
     * @dataProvider matchesProvider
     */
    public function testMatch($regexp, $returnVal)
    {
        $expectation = new ReturnExpectation(new Regexp($regexp));
        $this->assertInstanceOf(
            Success::CLASS,
            $expectation->validate(new Result($returnVal, ''))
        );
    }
}
