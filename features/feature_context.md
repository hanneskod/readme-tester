# Context for all feature tests

```
#[ReadmeTester\NamespaceName('feature-context')]
#[ReadmeTester\Name('scenario')]
#[ReadmeTester\Ignore]
```
```php
$defaultYamlConfigs = "
bootstrap: ''
suites:
    eval:
        runner: eval
    process:
        runner: process
";

$scenario = (new hanneskod\readmetester\Gherkish\FeatureContext)
    ->setup(function () use ($defaultYamlConfigs) {
        $this->commandLineArgs = [];
        $this->markdownFiles = [];
        $this->returnValue = 0;
        $this->parsedOutput = [];
        $this->rawOutput = '';
        $this->tempDir = sys_get_temp_dir().'/readmetester-features-'. rand().'/';
        mkdir($this->tempDir);
        file_put_contents($this->tempDir.'readme-tester.yaml.dist', $defaultYamlConfigs);
    })
    ->teardown(function () {
        exec("rm -rf {$this->tempDir}");
    })
    ->a_config_file(function (string $name, string $content) use ($defaultYamlConfigs) {
        file_put_contents($this->tempDir.$name, $defaultYamlConfigs."\n".$content);
    })
    ->a_markdown_file(function (string $content) {
        file_put_contents($this->tempDir.rand().'.md', $content);
    })
    ->a_file(function (string $name, string $content) {
        file_put_contents($this->tempDir.$name, $content);
    })
    ->the_command_line_argument(function (string $arg) {
        $this->commandLineArgs[] = $arg;
    })
    ->I_run_readme_tester(function () {
        $command = realpath('bin/readme-tester') . ' --output=json ' . implode(' ', $this->commandLineArgs);
        $cwd = getcwd();
        chdir($this->tempDir);
        exec($command, $this->rawOutput, $this->returnValue);
        $this->rawOutput = implode($this->rawOutput);
        $this->parsedOutput = json_decode($this->rawOutput, true);
        chdir($cwd);
    })
    ->the_output_is(function (string $expected) {
        if ($this->rawOutput != $expected) {
            throw new \Exception(
                sprintf(
                    "Expected output %s, found %s",
                    $expected,
                    $this->rawOutput,
                )
            );
        }
    })
    ->the_output_contains(function (string $expected) {
        if (!str_contains($this->rawOutput, $expected)) {
            throw new \Exception(
                sprintf(
                    "Expected output to contain %s, found %s",
                    $expected,
                    $this->rawOutput,
                )
            );
        }
    })
    ->the_count_for_x_is(function (string $field, int $expected) {
        // Divide by 2 as we use 2 suites
        $count = $this->parsedOutput['counts'][$field] / 2;

        if ($count != $expected) {
            throw new \Exception(
                sprintf(
                    "%s %s found, expected %s",
                    $field,
                    $count,
                    $expected,
                )
            );
        }
    })
    ->the_exit_code_is(function (int $expected) {
        if ($this->returnValue != $expected) {
            throw new \Exception(
                sprintf(
                    "Exited with status %s, expected %s",
                    $this->returnValue,
                    $expected,
                )
            );
        }
    })
    ->getScenario();

// This is a hack since we can not output three backticks thogheter
// without breaking the parser..
$PHPbegin = '``' . '`php';
$PHPend = '``' . '`';
```
