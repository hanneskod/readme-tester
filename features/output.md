<!--
#[ReadmeTester\Import('feature-context:scenario')]
-->

# Test output modes

## I get default content
```php
$scenario
    ->Given_a_file('foo.md', '')
    ->And_the_command_line_argument('--output default')
    ->When_I_run_readme_tester()
    ->Then_the_output_contains('Readme-Tester by Hannes Forsgård')
    ->And_the_exit_code_is(0)
;
```

## I get debug content
```php
$scenario
    ->Given_a_file('foo.md', '')
    ->And_the_command_line_argument('--output debug')
    ->When_I_run_readme_tester()
    ->Then_the_output_contains('Execution started')
    ->And_the_exit_code_is(0)
;
```

## I get json content
```php
$scenario
    ->Given_a_file('foo.md', '')
    ->And_the_command_line_argument('--output json')
    ->When_I_run_readme_tester()
    ->Then_the_output_contains('"tests":')
    ->And_the_exit_code_is(0)
;
```

## I get void content
```php
$scenario
    ->Given_a_file('foo.md', '')
    ->And_the_command_line_argument('--output void')
    ->When_I_run_readme_tester()
    ->Then_the_output_is('')
    ->And_the_exit_code_is(0)
;
```
