<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Execute code using eval()
 */
class EvalRunner implements RunnerInterface
{
    public function run(CodeBlock $codeBlock): Result
    {
        $returnValue = '';
        $exception = null;

        ob_start();

        try {
            $returnValue = eval($codeBlock);
        } catch (\Exception $e) {
            $exception = $e;
        }

        return new Result($returnValue, ob_get_clean(), $exception);
    }
}
