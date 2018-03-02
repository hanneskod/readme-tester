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
    private $tempDir;

    /**
     * @var string[] Arguments used when invoking readme-tester
     */
    private $args;

    /**
     * @var integer Return value of the last readme-tester execution
     */
    private $returnValue = 0;

    /**
     * @var array Parsed json formatted output from the last readme-tester execution
     */
    private $output;

    public function __construct(string $tempDir = '', array $args = [])
    {
        $this->tempDir = $tempDir ?: sys_get_temp_dir() . '/readmetester-behat-' . rand() . '/';
        mkdir($this->tempDir);
        $this->args = $args;
    }

    public function __destruct()
    {
        exec("rm -rf {$this->tempDir}");
    }

    /**
     * @Given a markdown file:
     */
    public function aMarkdownFile(PyStringNode $string)
    {
        file_put_contents($this->tempDir . rand() . '.md', (string)$string);
    }

    /**
     * @Given a source file :filename:
     */
    public function aSourceFile($filename, PyStringNode $string)
    {
        file_put_contents($this->tempDir . $filename, (string)$string);
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
        $command = realpath('bin/readme-tester') . " test {$this->tempDir} --format=json " . implode(' ', $this->args);
        $cwd = getcwd();
        chdir($this->tempDir);
        exec($command, $output, $this->returnValue);
        $this->output = json_decode(implode($output), true);
        chdir($cwd);
    }

    /**
     * @Then :number files are found
     */
    public function filesAreFound(int $number)
    {
        if ($this->output['counts']['files'] != $number) {
            throw new \Exception("{$this->output['counts']['files']} files found, expected $number");
        }
    }

    /**
     * @Then :number examples are evaluated
     */
    public function examplesAreEvaluated(int $number)
    {
        if ($this->output['counts']['examples'] != $number) {
            throw new \Exception("{$this->output['counts']['examples']} examples evaluated, expected $number");
        }
    }

    /**
     * @Then :number examples are ignored
     */
    public function examplesAreInored(int $number)
    {
        if ($this->output['counts']['ignored'] != $number) {
            throw new \Exception("{$this->output['counts']['ignored']} examples ignored, expected $number");
        }
    }

    /**
     * @Then :number expectations are found
     */
    public function expectationsAreFound(int $number)
    {
        if ($this->output['counts']['assertions'] != $number) {
            throw new \Exception("{$this->output['counts']['assertions']} assertions found, expected $number");
        }
    }

    /**
     * @Then :number failures are found
     */
    public function failuresAreFound($number)
    {
        if ($this->output['counts']['failures'] != $number) {
            throw new \Exception("{$this->output['counts']['failures']} failures found, expected $number");
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
