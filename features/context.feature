Feature: Example context
  In order to work with examples that require complex setups
  As a user
  I need to be able to create example contexts

  Scenario: I create a context
    Given a markdown file:
    """
    <<ReadmeTester\ExampleContext>>
    ```php
    $context = 'This output is matched using a regular expression';
    ```

    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    echo $context;
    ```

    <<ReadmeTester\ExpectOutput('/matched/')>>
    ```php
    echo $context;
    ```
    """
    When I run readme tester
    Then 2 expectations are found
    And 0 failures are found

  Scenario: I create a context using a hidden example
    Given a markdown file:
    """
    <!--
    <<ReadmeTester\ExampleContext>>
    ```php
    $context = 'This output is matched using a regular expression';
    ```
    -->

    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    echo $context;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I create a context using an ignored example
    Given a markdown file:
    """
    <<ReadmeTester\Ignore>>
    <<ReadmeTester\ExampleContext>>
    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    $context = 'This output is matched using a regular expression';
    ```

    <<ReadmeTester\ExpectOutput('/regular/')>>
    ```php
    echo $context;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I create multiple contexts
    Given a markdown file:
    """
    <<ReadmeTester\ExampleContext>>
    ```php
    $a = 'A';
    ```

    <<ReadmeTester\ExampleContext>>
    ```php
    $b = 'B';
    ```

    <<ReadmeTester\ExpectOutput('/^AB$/')>>
    ```php
    echo $a, $b;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I use a namespaced context
    Given a markdown file:
    """
    <<ReadmeTester\ExampleContext>>
    ```php
    namespace foospace;
    ```
    <<ReadmeTester\ExpectOutput('foospace')>>
    ```php
    echo __NAMESPACE__;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
