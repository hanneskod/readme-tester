<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Console;

use Symfony\Component\Console\Output\OutputInterface;
use hanneskod\readmetester\Expectation\Status;

/**
 * Presenter for normal (non-verbose) output
 */
class Presenter
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var integer The number of processed files
     */
    private $fileCount = 0;

    /**
     * @var integer The number of assertions
     */
    private $assertionCount = 0;

    /**
     * @var integer The number of failed assertions
     */
    private $failureCount = 0;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Called when a new test run starts
     */
    public function begin()
    {
        $this->output->writeln("Readme-Tester by Hannes Forsgård.");
    }

    /**
     * Called when a bootstrap has ben pulled
     */
    public function bootstrap(string $bootstrap)
    {
        $this->output->writeln("Loading bootstrap <comment>$bootstrap</comment>");
    }

    /**
     * Called when a test run ends
     */
    public function end()
    {
        $this->output->writeln(
            sprintf(
                "<%s>%s file%s tested, %s assertion%s, %s failure%s.</%s>",
                $this->hasFailures() ? 'error' : 'info',
                $this->fileCount,
                $this->fileCount == 1 ? '' : 's',
                $this->assertionCount,
                $this->assertionCount == 1 ? '' : 's',
                $this->failureCount,
                $this->failureCount == 1 ? '' : 's',
                $this->hasFailures() ? 'error' : 'info'
            )
        );
    }

    /**
     * Called when a new file is tested
     */
    public function beginFile(string $fileName)
    {
        $this->fileCount++;
        $this->output->writeln("Testing examples in <comment>$fileName</comment>");
    }

    /**
     * Called when an assertion is tested
     */
    public function beginAssertion(string $exampleName, Status $status)
    {
        $this->assertionCount++;

        if ($status->isSuccess()) {
            $this->success($exampleName, (string)$status);
            return;
        }

        $this->failureCount++;
        $this->failure($exampleName, (string)$status);
    }

    /**
     * Check if any failures have been recorded
     */
    public function hasFailures(): bool
    {
        return !!$this->failureCount;
    }

    /**
     * Called when an assertion is successfull
     */
    protected function success(string $exampleName, string $message)
    {
    }

    /**
     * Called when an assertion failes
     */
    protected function failure(string $exampleName, string $message)
    {
        $this->output->writeln("\n<error>Example $exampleName: $message</error>\n");
    }
}
