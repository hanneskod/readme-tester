<?php
namespace hanneskod\exemplify\Expectation;

class ExceptionExpectationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException hanneskod\exemplify\Exception
     */
    public function testEvaluate()
    {
        $expectation = new ExceptionExpectation('foo', 'bar', $this->getMock('hanneskod\exemplify\TestCase'));
        $expectation->evaluate('');
    }
}
