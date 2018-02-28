<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;
use Symfony\Component\Process\PhpProcess;

/**
 * Execute code in isolation using symfony php-process
 */
class IsolationRunner implements RunnerInterface
{
    /**
     * @return OutcomeInterface[]
     */
    public function run(CodeBlock $codeBlock): array
    {
        $process = new PhpProcess("<?php $codeBlock");

        $process->run();
        $outcomes = [];

        if ($errorOutput = $process->getErrorOutput()) {
            $outcomes[] = new ErrorOutcome(trim($errorOutput));
        } elseif ($output = $process->getOutput()) {
            $outcomes[] = new OutputOutcome($output);
        }

        return $outcomes;
    }
}
