Feature: Basic syntax
  In order to use readme tester
  As a user
  I need to be able to use a defined syntax

  Scenario: I parse a file with a non-PHP code block
    Given a markdown file:
    """
    ```
    This is not PHP content...
    ```
    """
    When I run readme tester
    Then 0 tests are executed

  Scenario: I parse a file with a PHP code block
    Given a markdown file:
    """
    ```php
    $a = 'foobar';
    ```
    """
    When I run readme tester
    Then 1 tests are executed
    And 0 failures are found

  Scenario: I ignore a PHP code block
    Given a markdown file:
    """
    <!-- @ignore -->
    ```php
    $a = 'foobar';
    ```
    """
    When I run readme tester
    Then 0 tests are executed

  Scenario: I use multiple annotation lines
    Given a markdown file:
    """
    <!-- @expectOutput /foo/ -->
    <!-- @expectOutput /bar/ -->
    ```php
    echo 'foobar';
    ```
    """
    When I run readme tester
    Then 2 tests are executed
    And 0 failures are found

  Scenario: I use an annotation block
    Given a markdown file:
    """
    <!--
        @expectOutput /foo/
        @expectOutput /bar/
    -->
    ```php
    echo 'foobar';
    ```
    """
    When I run readme tester
    Then 2 tests are executed
    And 0 failures are found

  Scenario: I include a code block
    Given a markdown file:
    """
    <!--
        @example parent
    -->
    ```php
    $str = 'parent';
    ```
    <!--
        @include parent
        @expectOutput /parent/
    -->
    ```php
    echo $str;
    ```
    """
    When I run readme tester
    Then 2 tests are executed
    And 0 failures are found

  Scenario: I include multiple code blocks
    Given a markdown file:
    """
    <!-- @example A -->
    ```php
    $A = 'A';
    ```
    <!-- @example B -->
    ```php
    $B = 'B';
    ```
    <!--
        @include A
        @include B
        @expectOutput /AB/
    -->
    ```php
    echo $A, $B;
    ```
    """
    When I run readme tester
    Then 3 tests are executed
    And 0 failures are found

  Scenario: I include a code block with a complex name
    Given a markdown file:
    """
    <!--
        @example "foo bar"
    -->
    ```php
    $str = 'foo bar';
    ```
    <!--
        @include "foo bar"
        @expectOutput "/foo bar/"
    -->
    ```php
    echo $str;
    ```
    """
    When I run readme tester
    Then 2 tests are executed
    And 0 failures are found
