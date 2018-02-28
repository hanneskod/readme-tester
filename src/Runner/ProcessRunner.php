<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;
use Symfony\Component\Process\PhpProcess;

/**
 * Execute code in isolation using symfony php-process
 */
class ProcessRunner implements RunnerInterface
{
    public function run(CodeBlock $codeBlock): OutcomeInterface
    {
        $process = new PhpProcess("<?php $codeBlock");
        $process->run();

        if ($errorOutput = $process->getErrorOutput()) {
            return new ErrorOutcome(trim($errorOutput));
        }

        if ($output = $process->getOutput()) {
            return new OutputOutcome($output);
        }

        return new VoidOutcome;
    }
}
