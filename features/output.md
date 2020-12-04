<!--
#[ReadmeTester\Import('feature-context:scenario')]
#[ReadmeTester\PrependCode('$scenario')]
#[ReadmeTester\AppendCode(';')]
-->

# Test output modes

## I get default content
```php
->Given_a_file('foo.md', '')
->And_the_command_line_argument('--output default')
->When_I_run_readme_tester()
->Then_the_output_contains('Readme-Tester by Hannes Forsgård')
->And_the_exit_code_is(0)
```

## More information is outputted in verbose mode
```php
->Given_a_file('foo.md', "
    $PHPbegin
    throw new \Exception('all of this long exception message should be display when invocated in verbose mode');
    $PHPend
")
->And_the_command_line_argument('--output default')
->And_the_command_line_argument('-v')
->When_I_run_readme_tester()
->Then_the_output_contains('verbose')
->And_the_exit_code_is(1)
```

## I get debug content
```php
->Given_a_file('foo.md', '')
->And_the_command_line_argument('--output debug')
->When_I_run_readme_tester()
->Then_the_output_contains('Execution started')
->And_the_exit_code_is(0)
```

## I get json content
```php
->Given_a_file('foo.md', '')
->And_the_command_line_argument('--output json')
->When_I_run_readme_tester()
->Then_the_output_contains('"tests":')
->And_the_exit_code_is(0)
```

## I get void content
```php
->Given_a_file('foo.md', '')
->And_the_command_line_argument('--output void')
->When_I_run_readme_tester()
->Then_the_output_is('')
->And_the_exit_code_is(0)
```
