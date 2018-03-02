<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Runner\RunnerInterface;

class EngineBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testFailWithNoRunner()
    {
        $this->expectException(\LogicException::CLASS);
        (new EngineBuilder)->buildEngine();
    }

    public function testBuildEngine()
    {
        $builder = new EngineBuilder;
        $builder->setRunner(
            $this->prophesize(RunnerInterface::CLASS)->reveal()
        );

        $this->assertInstanceOf(
            Engine::CLASS,
            $builder->buildEngine()
        );
    }
}
