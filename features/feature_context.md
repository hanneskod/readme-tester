#[ReadmeTester\NamespaceName('feature-context')]
#[ReadmeTester\Name('scenario')]
#[ReadmeTester\Ignore]
```php
$scenario = (new hanneskod\readmetester\Gherkish\PermutableFeatureContext)
    ->addPermutation(function () {
        $this->commandLineArgs = ['--runner=process'];
    })
    ->addPermutation(function () {
        $this->commandLineArgs = ['--runner=eval'];
    })
    ->setup(function () {
        $this->markdownFiles = [];
        $this->returnValue = 0;
        $this->output = [];
        $this->tempDir = sys_get_temp_dir() . '/readmetester-features-' . rand() . '/';
        mkdir($this->tempDir);
    })
    ->teardown(function () {
        exec("rm -rf {$this->tempDir}");
    })
    ->on('a_markdown_file', function (string $content) {
        file_put_contents($this->tempDir . rand() . '.md', $content);
    })
    ->on('a_file', function (string $name, string $content) {
        file_put_contents($this->tempDir . $name, $content);
    })
    ->on('the_command_line_argument', function (string $arg) {
        $this->commandLineArgs[] = $arg;
    })
    ->on('I_run_readme_tester', function () {
        $command = realpath('bin/readme-tester') . ' --output=json ' . implode(' ', $this->commandLineArgs);
        $cwd = getcwd();
        chdir($this->tempDir);
        exec($command, $output, $this->returnValue);
        $this->output = json_decode(implode($output), true);
        chdir($cwd);
    })
    ->on('the_count_for_x_is', function (string $count, int $expected) {
        if ($this->output['counts'][$count] != $expected) {
            throw new \Exception(
                sprintf(
                    "%s $count found, expected %s (using %s)",
                    $this->output['counts'][$count],
                    $expected,
                    implode(' ', $this->commandLineArgs)
                )
            );
        }
    })
    ->on('the_exit_code_is', function (int $expected) {
        if ($this->returnValue != $expected) {
            throw new \Exception(
                sprintf(
                    "Exited with status %s, expected %s (using %s)",
                    $this->returnValue,
                    $expected,
                    implode(' ', $this->commandLineArgs)
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
