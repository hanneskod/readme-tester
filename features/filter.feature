Feature: Filter argument
  In order to run failing tests during development
  As a user
  I need to be able to filter specific examples

  Scenario: I filter an example
    Given a markdown file:
    """
    <!--
        @example foo
        @expectOutput foo
    -->
    ```php
    echo 'foo';
    ```
    <!--
        @example bar
        @expectOutput bar
    -->
    ```php
    echo 'bar';
    ```
    """
    And the command line argument '--filter=bar'
    When I run readme tester
    Then 1 tests are executed

  Scenario: I filter multiple examples
    Given a markdown file:
    """
    <!-- @example 1 -->
    <!-- @expectOutput 1 -->
    ```php
    echo '1';
    ```
    <!-- @example 2 -->
    <!-- @expectOutput 2 -->
    ```php
    echo '2';
    ```
    <!-- @example foo -->
    <!-- @expectOutput foo -->
    ```php
    echo 'foo';
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
