<?php

namespace hanneskod\readmetester\Example;

// TODO replace with TransformationInterface
interface ProcessorInterface
{
    public function process(ExampleInterface $example): ExampleInterface;
}
