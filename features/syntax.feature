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
    Then 0 expectations are found

  Scenario: I parse a file with a PHP code block
    Given a markdown file:
    """
    ```php
    $a = 'foobar';
    ```
    """
    When I run readme tester
    Then 0 failures are found

  Scenario: I ignore a PHP code block
    Given a markdown file:
    """
    <<ReadmeTester\Ignore>>
    ```php
    $a = 'foobar';
    ```
    """
    When I run readme tester
    Then 0 expectations are found

  Scenario: I use multiple annotation lines
    Given a markdown file:
    """
    <<ReadmeTester\ExpectOutput('/foo/')>>
    <<ReadmeTester\ExpectOutput('/bar/')>>
    ```php
    echo 'foobar';
    ```
    """
    When I run readme tester
    Then 2 expectations are found
    And 0 failures are found

  Scenario: I use an html comment block
    Given a markdown file:
    """
    <!--
    <<ReadmeTester\ExpectOutput('/foo/')>>
    <<ReadmeTester\ExpectOutput('/bar/')>>
    -->
    ```php
    echo 'foobar';
    ```
    """
    When I run readme tester
    Then 2 expectations are found
    And 0 failures are found

  Scenario: I include a code block
    Given a markdown file:
    """
    <<ReadmeTester\Example('parent')>>
    ```php
    $str = 'parent';
    ```
    <<ReadmeTester\Import('parent')>>
    <<ReadmeTester\ExpectOutput('/parent/')>>
    ```php
    echo $str;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I include multiple code blocks
    Given a markdown file:
    """
    <<ReadmeTester\Example('A')>>
    ```php
    $A = 'A';
    ```
    <<ReadmeTester\Example('B')>>
    ```php
    $B = 'B';
    ```
    <<ReadmeTester\Import('A')>>
    <<ReadmeTester\Import('B')>>
    <<ReadmeTester\ExpectOutput('/AB/')>>
    ```php
    echo $A, $B;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I include a code block with a complex name
    Given a markdown file:
    """
    <<ReadmeTester\Example('foo-bar')>>
    ```php
    $str = 'foo bar';
    ```
    <<ReadmeTester\Import('foo-bar')>>
    <<ReadmeTester\ExpectOutput('/foo bar/')>>
    ```php
    echo $str;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
