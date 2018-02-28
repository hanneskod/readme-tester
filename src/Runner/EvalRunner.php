<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;

/**
 * Execute code using eval()
 */
class EvalRunner implements RunnerInterface
{
    /**
     * @return OutcomeInterface[]
     */
    public function run(CodeBlock $codeBlock): array
    {
        $outcomes = [];

        ob_start();

        try {
            $lastErrorBefore = error_get_last();
            @eval($codeBlock);
            $lastErrorAfter = error_get_last();
            if ($lastErrorBefore != $lastErrorAfter) {
                $outcomes[] = new ErrorOutcome("{$lastErrorAfter['type']}: {$lastErrorAfter['message']}");
            }
        } catch (\Throwable $e) {
            $outcomes[] = new ErrorOutcome((string)$e);
        }

        if ($output = ob_get_clean()) {
            $outcomes[] = new OutputOutcome($output);
        }

        return $outcomes;
    }
}
