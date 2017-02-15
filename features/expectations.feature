Feature: Example expectations
  In order to use readme tester
  As a user
  I need to be able to expect things on examples

  Scenario: I expect output using a regular expresion
    Given a markdown file:
    """
    <!-- @expectOutput /regular/ -->
    ```php
    echo 'This output is matched using a regular expression';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting output using a regular expresion
   Given a markdown file:
   """
   <!-- @expectOutput /regular/ -->
   ```php
   echo 'The regepxp does not match this..';
   ```
   """
   When I run readme tester
   Then 1 tests are executed
   And 1 failures are found
   And the exit code is 1

 Scenario: I expect output using a string
    Given a markdown file:
    """
    <!-- @expectOutput abc -->
    ```php
    echo 'abc';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting output using a string
    Given a markdown file:
    """
    <!-- @expectOutput abc -->
    ```php
    echo 'abcd';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 1 failures are found
    And the exit code is 1

 Scenario: I expect an exception
    Given a markdown file:
    """
    <!-- @expectException RuntimeException -->
    ```php
    throw new RuntimeException;
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

 Scenario: I fail expecting an exception
    Given a markdown file:
    """
    <!-- @expectException RuntimeException -->
    ```php
    // No exception is thrown here...
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 1 failures are found
    And the exit code is 1

 Scenario: I expect a returned scalar type
    Given a markdown file:
    """
    <!-- @expectReturnType string -->
    ```php
    return 'string';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

 Scenario: I expect a returned object
    Given a markdown file:
    """
    <!-- @expectReturnType DateTime -->
    ```php
    return new DateTime;
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

  Scenario: I expect a return value using a regular expresion
    Given a markdown file:
    """
    <!-- @expectReturn /regular/ -->
    ```php
    return 'This output is matched using a regular expression';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0

 Scenario: I expect a return value using a string
    Given a markdown file:
    """
    <!-- @expectReturn abc -->
    ```php
    return 'abc';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
    And the exit code is 0
