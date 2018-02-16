Feature: Example context
  In order to work with examples that require complex setups
  As a user
  I need to be able to create example contexts

  Scenario: I create a context using a hidden example
    Given a markdown file:
    """
    <!--
    @example context
    ```php
    $context = 'This output is matched using a regular expression';
    ```
    -->

    <!--
        @include context
        @expectOutput /regular/
    -->
    ```php
    echo $context;
    ```
    """
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found

  Scenario: I create a default context
    Given a markdown file:
    """
    <!--
    @exampleContext

    ```php
    $context = 'This output is matched using a regular expression';
    ```
    -->

    <!-- @expectOutput /regular/ -->
    ```php
    echo $context;
    ```

    <!-- @expectOutput /matched/ -->
    ```php
    echo $context;
    ```
    """
    When I run readme tester
    Then 2 expectations are found
    And 0 failures are found
