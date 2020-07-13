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

  Scenario: I specify the file extension
    Given a source file 'foo.BAR':
    """
    """
    And the command line argument '--file-extension=bar'
    When I run readme tester
    Then 1 files are found

  Scenario: I ignore a path
    Given a source file 'foo.md':
    """
    """
    And a source file 'bar.md':
    """
    """
    And the command line argument '--ignore=bar'
    When I run readme tester
    Then 1 files are found

  Scenario: I stop on failure
    Given a markdown file:
    """
    <!-- @expectOutput failure1 -->
    ```php
    ```
    <!-- @expectOutput failure2 -->
    ```php
    ```
    """
    Given a markdown file:
    """
    """
    And the command line argument '--stop-on-failure'
    When I run readme tester
    Then 1 failures are found
