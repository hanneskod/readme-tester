<?php

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Defines object that are able to execute example code
 */
interface RunnerInterface
{
    public function run(CodeBlock $codeBlock): OutcomeInterface;
}
