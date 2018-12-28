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
    /**
     * @var string
     */
    private $bootstrapCode;

    public function __construct(string $bootstrap = '')
    {
        $this->bootstrapCode = $bootstrap ? "require '$bootstrap';" : '';
    }

    public function run(CodeBlock $codeBlock): OutcomeInterface
    {
        $filename = (string)tempnam(sys_get_temp_dir(), 'doctestphp');

        file_put_contents($filename, "<?php $codeBlock");

        $process = new PhpProcess("<?php {$this->bootstrapCode} require '$filename';");
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
