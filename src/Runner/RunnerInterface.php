<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\CodeBlock;

/**
 * Runners are able to execute example code
 */
interface RunnerInterface
{
    public function run(CodeBlock $codeBlock): Result;
}
