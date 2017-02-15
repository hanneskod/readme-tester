<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var string Name of directory where test files are keept
     */
    private $sourceDir;

    /**
     * @var string[] Arguments used when invoking readme-tester
     */
    private $args = [];

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

    /**
     * @var integer Return value of the last readme-tester execution
     */
    private $returnValue = 0;

    public function __construct()
    {
        $this->sourceDir = sys_get_temp_dir() . '/readmetester-behat-' . rand() . '/';
        mkdir($this->sourceDir);
    }

    public function __destruct()
    {
        exec("rm -rf {$this->sourceDir}");
    }

    /**
     * @Given a markdown file:
     */
    public function aMarkdownFile(PyStringNode $string)
    {
        file_put_contents($this->sourceDir . rand() . '.md', (string)$string);
    }

    /**
     * @Given a source file :filename:
     */
    public function aSourceFile($filename, PyStringNode $string)
    {
        file_put_contents($this->sourceDir . $filename, (string)$string);
    }


   /**
     * @Given the command line argument :argument
     */
    public function theCommandLineArgument($argument)
    {
        $this->args[] = $argument;
    }


    /**
     * @When I run readme tester
     */
    public function iRunReadmeTester()
    {
        $command = realpath('bin/readme-tester') . " test {$this->sourceDir} " . implode(' ', $this->args);

        $cwd = getcwd();
        chdir($this->sourceDir);
        $lastLine = exec($command, $output, $this->returnValue);
        chdir($cwd);

        $success = preg_match('/^(\d+) files? tested, (\d+) assertions?, (\d+) failures?.$/', $lastLine, $matches);

        if (!$success) {
            throw new \Exception("Last line of output did not contain test report: ($lastLine)");
        }

        $this->fileCount = (int)$matches[1];
        $this->assertionCount = (int)$matches[2];
        $this->failureCount = (int)$matches[3];
    }

    /**
     * @Then :number tests are executed
     */
    public function testsAreExecuted(int $number)
    {
        if ($this->assertionCount != $number) {
            throw new \Exception("{$this->assertionCount} assertions tested, expected $number");
        }
    }

    /**
     * @Then :number failures are found
     */
    public function failuresAreFound($number)
    {
        if ($this->failureCount != $number) {
            throw new \Exception("{$this->failureCount} failures found, expected $number");
        }
    }

    /**
     * @Then the exit code is :code
     */
    public function theExitCodeIs(int $code)
    {
        if ($this->returnValue !== $code) {
            throw new \Exception("Readme tester exited with {$this->returnValue}, expected $code");
        }
    }
}
