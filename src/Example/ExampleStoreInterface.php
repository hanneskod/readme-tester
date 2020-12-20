<?php

namespace hanneskod\readmetester\Example;

interface ExampleStoreInterface
{
    /**
     * @return iterable<ExampleObj>
     */
    public function getExamples(): iterable;
}
