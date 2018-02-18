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
            $returnValue = null;

            try {
                $lastErrorBefore = error_get_last();
                $returnValue = @eval($codeBlock);
                $lastErrorAfter = error_get_last();
                if ($lastErrorBefore != $lastErrorAfter) {
                    $outcomes[] = new ErrorOutcome("{$lastErrorAfter['type']}: {$lastErrorAfter['message']}");
                }
            } catch (\Error $e) {
                $outcomes[] = new ErrorOutcome((string)$e);
            }

            if ($returnValue) {
                $outcomes[] = new ReturnOutcome(
                    is_scalar($returnValue) ? @(string)$returnValue : '',
                    gettype($returnValue),
                    is_object($returnValue) ? get_class($returnValue) : ''
                );
            }
        } catch (\Exception $e) {
            $outcomes[] = new ExceptionOutcome(
                get_class($e),
                $e->getMessage(),
                $e->getCode()
            );
        }

        if ($output = ob_get_clean()) {
            $outcomes[] = new OutputOutcome($output);
        }

        return $outcomes;
    }
}
