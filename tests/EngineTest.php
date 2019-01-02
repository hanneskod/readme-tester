<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\ExampleInterface;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Parser\Definition;

class EngineTest extends \PHPUnit\Framework\TestCase
{
    public function testFile()
    {
        $definition = $this->prophesize(Definition::CLASS);

        $parser = $this->prophesize(Parser::CLASS);
        $parser->parse('foobar')->willReturn([$definition]);

        $example = $this->prophesize(ExampleInterface::CLASS);

        $exampleFactory = $this->prophesize(ExampleFactory::CLASS);
        $exampleFactory->createExamples($definition)->willReturn([$example]);

        $tester = $this->prophesize(ExampleTester::CLASS);
        $tester->testExample($example)->shouldBeCalled();

        $engine = new Engine($parser->reveal(), $exampleFactory->reveal(), $tester->reveal());
        $engine->testFile('foobar');
    }

    public function testRegisterListener()
    {
        $parser = $this->prophesize(Parser::CLASS);
        $exampleFactory = $this->prophesize(ExampleFactory::CLASS);

        $listener = $this->prophesize(ListenerInterface::CLASS)->reveal();

        $tester = $this->prophesize(ExampleTester::CLASS);
        $tester->registerListener($listener)->shouldBeCalled();

        $engine = new Engine($parser->reveal(), $exampleFactory->reveal(), $tester->reveal());
        $engine->registerListener($listener);
    }
}
