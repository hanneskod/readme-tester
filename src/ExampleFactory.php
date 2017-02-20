<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

use hanneskod\readmetester\Expectation\ExpectationFactory;

/**
 * Create examples from definitions created by Parser
 */
class ExampleFactory
{
    /**
     * @var ExpectationFactory
     */
    private $expectationFactory;

    public function __construct(ExpectationFactory $expectationFactory = null)
    {
        $this->expectationFactory = $expectationFactory ?: new ExpectationFactory;
    }

    /**
     * Create examples from definitions
     *
     * @param  Definition[] $defenitions Example definitions as created by Parser
     * @return Example[]
     */
    public function createExamples(array $defenitions): array
    {
        $examples = [];
        $context = null;

        foreach ($defenitions as $index => $def) {
            if ($def->isAnnotatedWith('ignore')) {
                continue;
            }

            $name = $def->readAnnotation('example') ?: (string)($index + 1);

            if (isset($examples[$name])) {
                throw new \RuntimeException("Example '$name' already exists in definition ".($index + 1));
            }

            if ($context) {
                $def->getCodeBlock()->prepend($context);
            }

            if ($extends = $def->readAnnotation('extends')) {
                if (!isset($examples[$extends])) {
                    throw new \RuntimeException(
                        "Example '$extends' does not exist and can not be extended in definition ".($index + 1)
                    );
                }

                $def->getCodeBlock()->prepend($examples[$extends]->getCodeBlock());
            }

            $expectations = $this->createExpectations($def);

            if (empty($expectations)) {
                $expectations[] = $this->expectationFactory->createExpectation('expectnothing', []);
            }

            $examples[$name] = new Example($name, $def->getCodeBlock(), $expectations);

            if ($def->isAnnotatedWith('exampleContext')) {
                $context = $def->getCodeBlock();
            }
        }

        return $examples;
    }

    /**
     * Create expectation from definition data
     *
     * @return Expectation\ExpectationInterface[]
     */
    private function createExpectations(Definition $def): array
    {
        $expectations = [];

        foreach ($def->getAnnotations() as list($name, $args)) {
            $expectations[] = $this->expectationFactory->createExpectation($name, $args);
        }

        return array_filter($expectations);
    }
}
