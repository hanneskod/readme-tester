<?php

namespace hanneskod\readmetester\Example;

interface ProcessorInterface
{
    public function process(ExampleInterface $example): ExampleInterface;
}
