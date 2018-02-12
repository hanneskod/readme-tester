<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Expectation\Failure;
use hanneskod\readmetester\Expectation\Success;
use hanneskod\readmetester\Runner\OutcomeInterface;

class EvaluatorTest extends \PHPUnit\Framework\TestCase
{
    public function testThatUnhandledOutcomeCasesFailure()
    {
        $outcome = $this->prophesize(OutcomeInterface::CLASS);
        $outcome->__tostring()->willReturn('');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new Evaluator)->evaluate([], [$outcome->reveal()])[0]
        );
    }

    public function testThatUnhandlingExpectationCasesFailure()
    {
        $expectation = $this->prophesize(ExpectationInterface::CLASS);
        $expectation->__tostring()->willReturn('');
        $this->assertInstanceOf(
            Failure::CLASS,
            (new Evaluator)->evaluate([$expectation->reveal()], [])[0]
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

        $statuses = (new Evaluator)->evaluate([$exptA->reveal(), $exptB->reveal()], [$outcome->reveal()]);

        $this->assertInstanceOf(Failure::CLASS, $statuses[0]);
        $this->assertInstanceOf(Success::CLASS, $statuses[1]);
    }
}
