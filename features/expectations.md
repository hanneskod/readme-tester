<!--
#[ReadmeTester\Import('feature-context:scenario')]
#[ReadmeTester\PrependCode('$scenario')]
#[ReadmeTester\AppendCode(';')]
-->

# Test expectation failures

## I fail expecting output using a regular expresion
```php
->Given_a_markdown_file("
    #[ReadmeTester\ExpectOutput('/regular/')]
    $PHPbegin
    echo 'The regepxp does not match this..';
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```

## I fail expecting output using a string
```php
->Given_a_markdown_file("
    #[ReadmeTester\ExpectOutput('foo')]
    $PHPbegin
    echo 'foobar';
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```

## I fail expecting an error
```php
->Given_a_markdown_file("
    #[ReadmeTester\ExpectError('')]
    $PHPbegin
    // No exception is thrown here...
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```

## I fail as an error is not expected
```php
->Given_a_markdown_file("
    $PHPbegin
    throw new Exception;
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```

## I fail as output is not expected
```php
->Given_a_markdown_file("
    $PHPbegin
    echo 'foobar';
    $PHPend
")
->When_I_run_readme_tester()
->Then_the_count_for_x_is('assertions', 1)
->And_the_count_for_x_is('failures', 1)
->And_the_exit_code_is(1)
```
