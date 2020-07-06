<?php

namespace hanneskod\readmetester\Example;

interface ExampleStoreInterface
{
    /**
     * @return iterable<ExampleInterface>
     */
    public function getExamples(): iterable;
}
