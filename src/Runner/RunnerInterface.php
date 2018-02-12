<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Runners are able to execute example code
 */
interface RunnerInterface
{
    /**
     * @return OutcomeInterface[]
     */
    public function run(CodeBlock $codeBlock): array;
}
