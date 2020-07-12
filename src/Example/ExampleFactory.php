<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

use hanneskod\readmetester\Annotations;
use hanneskod\readmetester\Expectation\ExpectationFactory;
use hanneskod\readmetester\Expectation\ExpectationInterface;
use hanneskod\readmetester\Utils\NameObj;
use hanneskod\readmetester\Parser\Annotation;
use hanneskod\readmetester\Parser\Definition;

class ExampleFactory
{
    private ExpectationFactory $expectationFactory;
    private ProcessorInterface $processor;
    private bool $ignoreUnknownAnnotations;

    public function __construct(
        ExpectationFactory $expectationFactory,
        ProcessorInterface $processor,
        bool $ignoreUnknownAnnotations = false
    ) {
        $this->expectationFactory = $expectationFactory;
        $this->processor = $processor;
        $this->ignoreUnknownAnnotations = $ignoreUnknownAnnotations;
    }

    public function createExamples(Definition ...$defs): ExampleRegistry
    {
        $registry = new ExampleRegistry;
        $context = null;

        foreach ($defs as $index => $def) {
            $name = new NameObj('', uniqid());
            $code = $def->getCodeBlock();
            $expectations = [];
            $active = true;

            if ($context) {
                $code = $code->prepend($context);
            }

            foreach ($def->getAnnotations() as $annotation) {
                if ($annotation->isNamed(Annotations::ANNOTATION_IGNORE)) {
                    $active = false;
                    continue;
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_EXAMPLE)) {
                    if ($annotation->getArgument()) {
                        $name = new NameObj($name->getNamespaceName(), $annotation->getArgument());
                    }
                    continue;
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_INCLUDE)) {
                    $nameToInclude = new NameObj('', $annotation->getArgument());

                    if (!$registry->hasExample($nameToInclude)) {
                        throw new \RuntimeException(
                            "Example '{$annotation->getArgument()}' can not be included in {$name->getShortName()}"
                        );
                    }

                    $code = $code->prepend($registry->getExample($nameToInclude)->getCodeBlock());
                    continue;
                }

                if ($expectation = $this->expectationFactory->createExpectation($annotation)) {
                    if ($expectation instanceof ExpectationInterface) {
                        $expectations[] = $expectation;
                        continue;
                    }
                }

                if ($annotation->isNamed(Annotations::ANNOTATION_CONTEXT)) {
                    $context = $code;
                    continue;
                }

                if (!$this->ignoreUnknownAnnotations) {
                    throw new \RuntimeException("Unknown annotation @{$annotation->getName()}");
                }
            }

            if ($registry->hasExample($name)) {
                throw new \RuntimeException("Example '{$name->getShortName()}' already exists");
            }

            $example = new ExampleObj($name, $code);

            foreach ($expectations as $expectation) {
                $example = $example->withExpectation($expectation);
            }

            $example = $example->withActive($active);

            $registry->setExample(
                $this->processor->process(
                    $example
                )
            );
        }

        return $registry;
    }
}
