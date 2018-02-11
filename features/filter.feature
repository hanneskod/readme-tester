Feature: Filter argument
  In order to run failing tests during development
  As a user
  I need to be able to filter specific examples

  Scenario: I filter an example
    Given a markdown file:
    """
    <!-- @example foo -->
    ```php
    // This is example foo
    ```
    <!-- @example bar -->
    ```php
    // This is example bar
    ```
    """
    And the command line argument '--filter=bar'
    When I run readme tester
    Then 1 tests are executed

  Scenario: I filter multiple examples
    Given a markdown file:
    """
    ```php
    // This is example 1
    ```
    ```php
    // This is example 2
    ```
    <!-- @example foo -->
    ```php
    // This is example foo
    ```
    """
    And the command line argument '--filter=/[0-9]+/'
    When I run readme tester
    Then 2 tests are executed

  Scenario: I filter an inherited example
    Given a markdown file:
    """
    <!-- @example foo -->
    ```php
    $str = 'foo';
    ```
    <!--
        @example bar
        @include foo
        @expectOutput foo
    -->
    ```php
    echo $str;
    ```
    """
    And the command line argument '--filter=bar'
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found
