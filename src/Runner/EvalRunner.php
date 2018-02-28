<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Execute code using eval()
 */
class EvalRunner implements RunnerInterface
{
    public function run(CodeBlock $codeBlock): OutcomeInterface
    {
        ob_start();

        try {
            $lastErrorBefore = error_get_last();
            @eval($codeBlock);
            $lastErrorAfter = error_get_last();
            if ($lastErrorBefore != $lastErrorAfter) {
                ob_end_clean();
                return new ErrorOutcome("{$lastErrorAfter['type']}: {$lastErrorAfter['message']}");
            }
        } catch (\Throwable $e) {
            ob_end_clean();
            return new ErrorOutcome((string)$e);
        }

        if ($output = ob_get_clean()) {
            return new OutputOutcome($output);
        }

        return new VoidOutcome;
    }
}
