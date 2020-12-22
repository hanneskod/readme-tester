<!--
#[ReadmeTester\Import('feature-context:scenario')]
#[ReadmeTester\PrependCode('$scenario')]
#[ReadmeTester\AppendCode(';')]
-->

# Test output modes

## I get default output
```php
->Given_a_markdown_file('')
->And_the_command_line_argument('--output default')
->When_I_run_readme_tester()
->Then_the_output_contains('Readme-Tester by Hannes Forsgård')
->And_the_exit_code_is(0)
```

## More information is outputted in verbose mode
```php
->Given_a_markdown_file("
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

## I get debug output
```php
->Given_a_markdown_file("
    #[ReadmeTester\IgnoreOutput]
    $PHPbegin
    echo 1+2;
    $PHPend
")
->And_the_command_line_argument('--output debug')
->When_I_run_readme_tester()
->Then_the_output_contains('IgnoreOutput')
->Then_the_output_contains('1+2')
->Then_the_output_contains('3')
->And_the_exit_code_is(0)
```

## I get debug output using the debug option
```php
->Given_a_markdown_file("
    #[ReadmeTester\IgnoreOutput]
    $PHPbegin
    echo 1+2;
    $PHPend
")
->And_the_command_line_argument('--debug')
->When_I_run_readme_tester()
->Then_the_output_contains('IgnoreOutput')
->Then_the_output_contains('1+2')
->Then_the_output_contains('3')
->And_the_exit_code_is(0)
```

## I get json output
```php
->Given_a_markdown_file('')
->And_the_command_line_argument('--output json')
->When_I_run_readme_tester()
->Then_the_output_contains('"tests":')
->And_the_exit_code_is(0)
```

## I get void output
```php
->Given_a_markdown_file('')
->And_a_config_file('readme-tester.yaml', '
output_format: ""
')
// The following line is a hack to override the default --output option in feature_context
->And_the_command_line_argument('--output ""')
->When_I_run_readme_tester()
->Then_the_output_equals('')
->And_the_exit_code_is(0)
```

## I get error using default output
```php
->Given_the_command_line_argument('--output default')
->And_the_command_line_argument('--runner does-not-exist')
->When_I_run_readme_tester()
->Then_the_output_contains('Invalid runner')
->And_the_exit_code_is(1)
```

## I get error using json output
```php
->Given_the_command_line_argument('--output json')
->And_the_command_line_argument('--input does-not-exist')
->When_I_run_readme_tester()
->Then_the_output_contains('Invalid input language')
->And_the_exit_code_is(1)
```
