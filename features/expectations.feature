Feature: Example expectations
  In order to use readme tester
  As a user
  I need to be able to expect things on examples

  Scenario: I expect output using a regular expresion
    Given a markdown file:
    """
    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    echo 'This output is matched using a regular expression';
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting output using a regular expresion
    Given a markdown file:
    """
    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    echo 'The regepxp does not match this..';
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I expect output using a string
    Given a markdown file:
    """
    <<ReadmeTester\ExpectOutput('abc')>>
    ```php
    echo 'abc';
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting output using a string
    Given a markdown file:
    """
    <<ReadmeTester\ExpectOutput('abc')>>
    ```php
    echo 'abcd';
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I ignore output
    Given a markdown file:
    """
    <<ReadmeTester\IgnoreOutput>>
    ```php
    echo 'abc';
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

  Scenario: I expect an error
    Given a markdown file:
    """
    <<ReadmeTester\ExpectError('/this_function_does_not_exist/')>>
    ```php
    this_function_does_not_exist();
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

  Scenario: I ignore an error
    Given a markdown file:
    """
    <<ReadmeTester\IgnoreError>>
    ```php
    this_function_does_not_exist();
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

 Scenario: I expect an exception
    Given a markdown file:
    """
    <<ReadmeTester\ExpectError('/RuntimeException/')>>
    ```php
    throw new RuntimeException;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting an error
    Given a markdown file:
    """
    <<ReadmeTester\ExpectError('')>>
    ```php
    // No exception is thrown here...
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I fail as an error is not expected
    Given a markdown file:
    """
    ```php
    throw new Exception;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I fail as output is not expected
    Given a markdown file:
    """
    ```php
    echo "foobar";
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1
