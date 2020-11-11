Feature: Example expectations
  In order to use readme tester
  As a user
  I need to be able to expect things on examples

 Scenario: I fail expecting output using a regular expresion
    Given a markdown file:
    """
    #[ReadmeTester\ExpectOutput('/regular/')]
    ```php
    echo 'The regepxp does not match this..';
    ```
    """
    And the command line argument '--no-bootstrap'
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I fail expecting output using a string
    Given a markdown file:
    """
    #[ReadmeTester\ExpectOutput('abc')]
    ```php
    echo 'abcd';
    ```
    """
    And the command line argument '--no-bootstrap'
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1

 Scenario: I fail expecting an error
    Given a markdown file:
    """
    #[ReadmeTester\ExpectError('')]
    ```php
    // No exception is thrown here...
    ```
    """
    And the command line argument '--no-bootstrap'
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
    And the command line argument '--no-bootstrap'
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
    And the command line argument '--no-bootstrap'
    When I run readme tester
    Then 1 expectations are found
    And 1 failures are found
    And the exit code is 1
