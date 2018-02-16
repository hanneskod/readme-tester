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
