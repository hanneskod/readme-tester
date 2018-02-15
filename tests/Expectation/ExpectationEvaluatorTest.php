<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Expectation;

use hanneskod\readmetester\Runner\OutcomeInterface;

class ExpectationEvaluatorTest extends \PHPUnit\Framework\TestCase
{
    public function testThatUnhandledOutcomeCasesFailure()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->__tostring()->willReturn('');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ExpectationEvaluator)->evaluate([], [$outcome->reveal()])[0]
        );
    }

    public function testThatUnhandlingExpectationCasesFailure()
    {
        $expectation = $this->prophesize(ExpectationInterface::CLASS);
        $expectation->__tostring()->willReturn('');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new ExpectationEvaluator)->evaluate([$expectation->reveal()], [])[0]
        );
    }

    public function testHandle()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->__tostring()->willReturn('');

        $exptA = $this->prophesize(ExpectationInterface::CLASS);
        $exptA->__tostring()->willReturn('');
        $exptA->handles($outcome)->willReturn(false);

        $exptB = $this->prophesize(ExpectationInterface::CLASS);
        $exptB->__tostring()->willReturn('');
        $exptB->handles($outcome)->willReturn(true);
        $exptB->handle($outcome)->willReturn(new Success(''));

        $statuses = (new ExpectationEvaluator)->evaluate([$exptA->reveal(), $exptB->reveal()], [$outcome->reveal()]);

        $this->assertInstanceOf(Failure::CLASS, $statuses[0]);
        $this->assertInstanceOf(Success::CLASS, $statuses[1]);
    }
}
