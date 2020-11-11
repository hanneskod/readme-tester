<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;
use Symfony\Component\Process\PhpProcess;

/**
 * Execute code in isolation using symfony php-process
 */
final class ProcessRunner implements RunnerInterface
{
    private string $bootstrap;

    public function __construct(string $bootstrap = '')
    {
        $this->bootstrap = $bootstrap;
    }

    public function run(ExampleObj $example): OutcomeInterface
    {
        $filename = (string)tempnam(sys_get_temp_dir(), 'doctestphp');

        file_put_contents($filename, "<?php {$example->getCodeBlock()->getCode()}");

        $process = new PhpProcess("<?php {$this->bootstrap} require '$filename';");
        $process->run();

        unlink($filename);

        if ($errorOutput = $process->getErrorOutput()) {
            return new ErrorOutcome(trim($errorOutput));
        }

        if ($output = $process->getOutput()) {
            return new OutputOutcome($output);
        }

        return new VoidOutcome;
    }
}
