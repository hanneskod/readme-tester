<!--
#[ReadmeTester\Import('feature-context:scenario')]
#[ReadmeTester\PrependCode('$scenario')]
#[ReadmeTester\AppendCode(';')]
-->

# Test the command linte interface

## I evaluate multiple files
```php
->Given_a_markdown_file('# First file')
->And_a_markdown_file('# Second file')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 2)
->And_the_exit_code_is(0)
```

## I specify the file extension
```php
->Given_a_file('foo.bar', '')
->And_the_command_line_argument('--file-extension=bar')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I ignore a path
```php
->Given_a_file('foo.md', '')
->Given_a_file('bar.md', '')
->And_the_command_line_argument('--exclude=bar')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## Scanning paths is case-insensitive
```php
->Given_a_file('foo.md', '')
->And_a_file('bar.md', '')
->And_a_file('foobar.md', '')
->And_the_command_line_argument('FOO.md')
->And_the_command_line_argument('--file-extension=MD')
->And_the_command_line_argument('--exclude=FOOBAR.MD')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I stop on failure
```php
->Given_a_markdown_file("
    #[ReadmeTester\ExpectOutput('failure1')]
    $PHPbegin
    $PHPend

    #[ReadmeTester\ExpectOutput('failure2')]
    $PHPbegin
    $PHPend
")
->And_the_command_line_argument('--stop-on-failure')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```

## I fail as input is invalid
```php
->Given_a_markdown_file("
    #[attr('missing-closing-parenthesis']
    $PHPbegin
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('errors', 1)
->And_the_exit_code_is(1)
```

## I use a bootstrap
```php
->Given_a_file(
    'foo.php',
    "<?php function foo() {echo 'foo';}"
)
->And_a_markdown_file("
    #[ReadmeTester\ExpectOutput('foo')]
    $PHPbegin
    foo();
    $PHPend
")
->And_the_command_line_argument('--bootstrap=foo.php')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_exit_code_is(0)
```

## I load a custom runner
```php
->Given_a_file(
    'runner.php',
    '<?php
    namespace hanneskod\readmetester\Runner;
    use hanneskod\readmetester\Example\ExampleStoreInterface;
    class CustomRunner implements RunnerInterface
    {
        public function run(ExampleStoreInterface $store): iterable
        {
            foreach ($store->getExamples() as $example) {
                yield new OutputOutcome($example, self::class);
            }
        }
        public function setBootstrap(string $filename): void
        {
        }
    }
')
->And_a_markdown_file("
    #[ReadmeTester\ExpectOutput('/CustomRunner/')]
    $PHPbegin
    // nothing here, but the runner always returns its classname
    $PHPend
")
->And_the_command_line_argument('--bootstrap=runner.php')
->And_the_command_line_argument('--runner=hanneskod\\\readmetester\\\Runner\\\CustomRunner')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 0)
->And_the_exit_code_is(0)
```

## I filter examples
```php
->Given_a_markdown_file("
    #[ReadmeTester\Name('foo')]
    $PHPbegin
    $PHPend

    #[ReadmeTester\Name('bar')]
    $PHPbegin
    $PHPend
")
->And_the_command_line_argument('--filter foo')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('examples', 1)
->And_the_exit_code_is(0)
```

## I read input from stdin
```php
->Given_a_file(
    'foobar',
    "
    $PHPbegin
    echo 'triggers failure';
    $PHPend
")
->And_the_command_line_prefix('cat foobar |')
->And_the_command_line_argument('--stdin')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('examples', 1)
->Then_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```
