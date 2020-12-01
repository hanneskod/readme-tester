<!--
#[ReadmeTester\Import('feature-context:scenario')]
-->

# Testing loading config files

## I load a default config file
```php
$scenario
    ->Given_a_file('foo.BAR', '')
    ->And_a_file('readme-tester.yaml', 'file_extensions: [BAR]')
    ->And_the_command_line_argument('--no-bootstrap')
    ->When_I_run_readme_tester()
    ->Then_the_count_for_x_is('files', 1)
    ->And_the_exit_code_is(0)
;
```

## I load a dist config file
```php
$scenario
    ->Given_a_file('foo.BAR', '')
    ->And_a_file('readme-tester.yaml.dist', 'file_extensions: [BAR]')
    ->And_the_command_line_argument('--no-bootstrap')
    ->When_I_run_readme_tester()
    ->Then_the_count_for_x_is('files', 1)
    ->And_the_exit_code_is(0)
;
```

## I have a dist and a default config file
```php
$scenario
    ->Given_a_file('foo.BAR', '')
    ->And_a_file('readme-tester.yaml', 'file_extensions: [FOO]')
    ->And_a_file('readme-tester.yaml.dist', 'file_extensions: [BAR]')
    ->And_the_command_line_argument('--no-bootstrap')
    ->When_I_run_readme_tester()
    ->Then_the_count_for_x_is('files', 0)
    ->And_the_exit_code_is(0)
;
```

## I load a custom config file
```php
$scenario
    ->Given_a_file('foo.BAR', '')
    ->And_a_file('config.yaml', 'file_extensions: [BAR]')
    ->And_the_command_line_argument('--no-bootstrap')
    ->And_the_command_line_argument('--config config.yaml')
    ->When_I_run_readme_tester()
    ->Then_the_count_for_x_is('files', 1)
    ->And_the_exit_code_is(0)
;
```
