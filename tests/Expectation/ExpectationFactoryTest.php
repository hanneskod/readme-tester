<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Parser\Annotation;

/**
 * @covers \hanneskod\readmetester\Expectation\ExpectationFactory
 */
class ExpectationFactoryTest extends \PHPUnit\Framework\TestCase
{
    function testCreateNothing()
    {
        $this->assertNull(
            (new ExpectationFactory)->createExpectation(new Annotation('foo'))
        );
    }

    function testCreateOutputExpectation()
    {
        $this->assertEquals(
            new OutputExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectOutput', 'arg'))
        );
    }

    function testCreateOutputExpectationWithNoArgumnet()
    {
        $this->assertEquals(
            new OutputExpectation(new Regexp('//')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectOutput'))
        );
    }

    function testCreateErrorExpectation()
    {
        $this->assertEquals(
            new ErrorExpectation(new Regexp('arg')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectError', 'arg'))
        );
    }

    function testCreateErrorExpectationWithNoArgumnet()
    {
        $this->assertEquals(
            new ErrorExpectation(new Regexp('//')),
            (new ExpectationFactory)->createExpectation(new Annotation('expectError'))
        );
    }
}
