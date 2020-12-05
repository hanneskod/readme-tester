<!--
#[ReadmeTester\Import('feature-context:scenario')]
#[ReadmeTester\PrependCode('$scenario')]
#[ReadmeTester\AppendCode(';')]
-->

# Test configuration

## I load a default config file
```php
->Given_a_file('foo.BAR', '')
->And_a_config_file('readme-tester.yaml', '
defaults:
    file_extensions: [BAR]
')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I load a dist config file
```php
->Given_a_file('foo.BAR', '')
->And_a_config_file('readme-tester.yaml.dist', '
defaults:
    file_extensions: [BAR]
')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I have a dist and a default config file
```php
->Given_a_file('foo.FOO', '')
->And_a_config_file('readme-tester.yaml', '
defaults:
    file_extensions: [FOO]
')
->And_a_config_file('readme-tester.yaml.dist', '
defaults:
    file_extensions: [BAR]
')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I load a custom config file
```php
->Given_a_file('foo.BAR', '')
->And_a_config_file('config.yaml', '
defaults:
    file_extensions: [BAR]
')
->And_the_command_line_argument('--config config.yaml')
->When_I_run_readme_tester()
->Then_the_count_for_x_is('files', 1)
->And_the_exit_code_is(0)
```

## I ignore config file
```php
->Given_a_file('foo.FOO', "
$PHPbegin
this error should be ignored as config file is not loaded
and hence this file is never parsed
$PHPend
")
->And_a_config_file('readme-tester.yaml', '
defaults:
    file_extensions: [FOO]
')
->And_the_command_line_argument('--no-config')
->And_the_command_line_argument('--no-bootstrap')
->When_I_run_readme_tester()
->And_the_exit_code_is(0)
```
