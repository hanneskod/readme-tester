<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Utils\CodeBlock;
use Symfony\Component\Process\PhpProcess;

/**
 * Execute code in isolation using symfony php-process
 */
final class ProcessRunner implements RunnerInterface
{
    private CodeBlock $bootstrap;

    public function __construct()
    {
        $this->bootstrap = new CodeBlock('');
    }

    public function setBootstrap(CodeBlock $bootstrap): void
    {
        $this->bootstrap = $bootstrap;
    }

    public function run(ExampleObj $example): OutcomeInterface
    {
        $filename = (string)tempnam(sys_get_temp_dir(), 'doctestphp');

        file_put_contents($filename, "<?php {$example->getCodeBlock()->getCode()}");

        $process = new PhpProcess("<?php {$this->bootstrap->getCode()} require '$filename';");
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
