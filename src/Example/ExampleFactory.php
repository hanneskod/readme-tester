<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Parser\Annotation;
use hanneskod\readmetester\Parser\Definition;

/**
 * Create Examples objects from Definitions
 */
class ExampleFactory
{
    /**
     * @var ExpectationFactory
     */
    private $expectationFactory;

    /**
     * @var FilterInterface
     */
    private $filter;

    public function __construct(ExpectationFactory $expectationFactory, FilterInterface $filter = null)
    {
        $this->expectationFactory = $expectationFactory;
        $this->filter = $filter ?: new NullFilter;
    }

    /**
     * Create examples from definitions
     *
     * @return Example[]
     */
    public function createExamples(Definition ...$defs): array
    {
        $examples = [];
        $context = null;

        foreach ($defs as $index => $def) {
            $name = '';
            $code = $def->getCodeBlock();
            $expectations = [];
            $ignoreExample = false;

            if ($context) {
                $code = $code->prepend($context);
            }

            foreach ($def->getAnnotations() as $annotation) {
                if ($annotation->isNamed('ignore')) {
                    $ignoreExample = true;
                    continue;
                }

                if ($annotation->isNamed('example')) {
                    $name = $annotation->getArgument();
                    continue;
                }

                if ($annotation->isNamed('include')) {
                    $toInclude = $annotation->getArgument();

                    if (!isset($examples[$toInclude])) {
                        throw new \RuntimeException(
                            "Example '$toInclude' does not exist and can not be included in definition ".($index + 1)
                        );
                    }

                    $code = $code->prepend($examples[$toInclude]->getCodeBlock());
                    continue;
                }

                if ($expectation = $this->expectationFactory->createExpectation($annotation)) {
                    $expectations[] = $expectation;
                    continue;
                }

                if ($annotation->isNamed('exampleContext')) {
                    $context = $code;
                    continue;
                }

                throw new \RuntimeException("Unknown annotation @{$annotation->getName()}");
            }

            if (isset($examples[$name])) {
                throw new \RuntimeException("Example '$name' already exists in definition ".($index + 1));
            }

            if (!$this->filter->isValid($name)) {
                $ignoreExample = true;
            }

            if (!$name) {
                $name = (string)($index + 1);
            }

            $examples[$name] = $ignoreExample
                ? new IgnoredExample($name, $code, $expectations)
                : new Example($name, $code, $expectations);
        }

        return $examples;
    }
}