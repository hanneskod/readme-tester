<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester;

use hanneskod\readmetester\Engine;
use hanneskod\readmetester\ExampleTester;
use hanneskod\readmetester\ListenerInterface;
use hanneskod\readmetester\Example\ExampleFactory;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleRegistry;
use hanneskod\readmetester\Parser\Parser;
use hanneskod\readmetester\Parser\Definition;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EngineSpec extends ObjectBehavior
{
    function it_tests_file(
        Definition $definition,
        Parser $parser,
        ExampleObj $example,
        ExampleRegistry $registry,
        ExampleFactory $exampleFactory,
        ExampleTester $tester
    ) {
        $parser->parse('foobar')->willReturn([$definition]);
        $registry->getExamples()->willReturn([$example]);
        $exampleFactory->createExamples($definition)->willReturn($registry);

        $tester->testExample($example)->shouldBeCalled();

        $this->beConstructedWith($parser, $exampleFactory, $tester);

        $this->testFile('foobar');
    }

    function it_registers_listener(
        Parser $parser,
        ExampleFactory $exampleFactory,
        ListenerInterface $listener,
        ExampleTester $tester
    ) {
        $tester->registerListener($listener)->shouldBeCalled();

        $this->beConstructedWith($parser, $exampleFactory, $tester);

        $this->registerListener($listener);
    }
}
