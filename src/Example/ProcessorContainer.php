<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Example;

/**
 * Chain of processors
 */
final class ProcessorContainer implements ProcessorInterface
{
    /** @var ProcessorInterface[] */
    private $processors;

    public function __construct(ProcessorInterface ...$processors)
    {
        $this->processors = $processors;
    }

    public function process(ExampleInterface $example): ExampleInterface
    {
        foreach ($this->processors as $processor) {
            $example = $processor->process($example);
        }

        return $example;
    }
}
