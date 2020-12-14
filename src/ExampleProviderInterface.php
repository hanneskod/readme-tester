<?php

namespace hanneskod\readmetester;

use hanneskod\readmetester\Config\Suite;
use hanneskod\readmetester\Example\ExampleStoreInterface;

interface ExampleProviderInterface
{
    public function getExamplesForSuite(Suite $suite): ExampleStoreInterface;
}
