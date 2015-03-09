<?php

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Result;

class ReturnTypeExpectationTest extends \PHPUnit_Framework_TestCase
{
    public function testGettypeNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new ReturnTypeExpectation('integer'))->validate(new Result('string', ''));
    }

    public function testClassNoMatch()
    {
        $this->setExpectedException('UnexpectedValueException');
        (new ReturnTypeExpectation('Exception'))->validate(new Result('string', ''));
    }

    public function typeProvider()
    {
        return array(
            array('BOOLEAN', true),
            array('integer', 123),
            array('double', 1.1),
            array('string', '123'),
            array('array', array()),
            array('null', null),
            array('Exception', new \Exception),
        );
    }

    /**
     * @dataProvider typeProvider
     */
    public function testInteger($expected, $value)
    {
        $this->assertNull(
            (new ReturnTypeExpectation($expected))->validate(new Result($value, ''))
        );
    }
}
