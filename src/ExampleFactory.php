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

    public function __construct(ExpectationFactory $expectationFactory)
    {
        $this->expectationFactory = $expectationFactory;
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

            $name = (string)($index + 1);
            $code = $def->getCodeBlock();

            if ($def->isAnnotatedWith('example')) {
                $name = $def->getAnnotation('example')->getArgument();
            }

            if (isset($examples[$name])) {
                throw new \RuntimeException("Example '$name' already exists in definition ".($index + 1));
            }

            if ($context) {
                $code = $code->prepend($context);
            }

            if ($def->isAnnotatedWith('extends')) {
                $extends = $def->getAnnotation('extends')->getArgument();
                if (!isset($examples[$extends])) {
                    throw new \RuntimeException(
                        "Example '$extends' does not exist and can not be extended in definition ".($index + 1)
                    );
                }

                $code = $code->prepend($examples[$extends]->getCodeBlock());
            }

            $expectations = $this->createExpectations($def);

            if (empty($expectations)) {
                $expectations[] = $this->expectationFactory->createExpectation(new Annotation('expectNothing'));
            }

            $examples[$name] = new Example($name, $code, $expectations);

            if ($def->isAnnotatedWith('exampleContext')) {
                $context = $code;
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

        foreach ($def->getAnnotations() as $annotation) {
            $expectations[] = $this->expectationFactory->createExpectation($annotation);
        }

        return array_filter($expectations);
    }
}
