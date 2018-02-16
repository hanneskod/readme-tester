Feature: CLI features
  In order to work with sets of examples
  As a user
  I need to be able to apply cli switches

  Scenario: I evaluate multiple files
    Given a markdown file:
    """
    # First file
    """
    And a markdown file:
    """
    # Second file
    """
    When I run readme tester
    Then 2 files are found

  Scenario: I ignore unknown annotations
    Given a markdown file:
    """
    <!-- @thisAnnotationDoesNotExist -->
    ```php
    // example
    ```
    """
    And the command line argument '--ignore-unknown-annotations'
    When I run readme tester
    Then 1 examples are evaluated
