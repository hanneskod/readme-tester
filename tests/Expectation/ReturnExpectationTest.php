<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class ReturnExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new ReturnExpectation(new Regexp('/foo/'));
        $expectation->validate(new Result('bar', ''));
    }

    public function testMatchOfNonString()
    {
        $this->setExpectedException('UnexpectedValueException');
        $expectation = new ReturnExpectation(new Regexp(''));
        $expectation->validate(new Result([], ''));
    }

    public function matchesProvider()
    {
        return array(
            array('/foo/', 'foo'),
            array('1', '1'),
            array('1', 1),
            array('1', true),
            array('/1\.5/', 1.5),
            array('//', null),
            array('/Exception/', new \Exception),
        );
    }

    /**
     * @dataProvider matchesProvider
     */
    public function testMatch($regexp, $returnVal)
    {
        $expectation = new ReturnExpectation(new Regexp($regexp));
        $this->assertNull(
            $expectation->validate(new Result($returnVal, ''))
        );
    }
}
