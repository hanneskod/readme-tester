<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Utils\CodeBlock;

/**
 * Execute code using eval()
 */
final class EvalRunner implements RunnerInterface
{
    public function __construct(string $bootstrap = '')
    {
        if ($bootstrap) {
            if (!file_exists($bootstrap)) {
                throw new \RuntimeException("Unable to load bootstrap $bootstrap, file does not exist");
            }
            require_once $bootstrap;
        }
    }

    public function run(CodeBlock $codeBlock): OutcomeInterface
    {
        ob_start();

        try {
            $lastErrorBefore = error_get_last();
            eval($codeBlock->getCode());
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
