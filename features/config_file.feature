Feature: Configuration file features

  Scenario: I load a default config file
    Given a source file 'foo.BAR':
    """
    """
    And a source file 'readme-tester.yaml':
    """
    file_extensions: [BAR]
    """
    And the command line argument '--no-bootstrap'
    When I run readme tester
    Then 1 files are found

 Scenario: I load a dist config file
   Given a source file 'foo.BAR':
   """
   """
   And a source file 'readme-tester.yaml.dist':
   """
   file_extensions: [BAR]
   """
   And the command line argument '--no-bootstrap'
   When I run readme tester
   Then 1 files are found

 Scenario: I have a dist and a default config file
   Given a source file 'foo.BAR':
   """
   """
   And a source file 'readme-tester.yaml':
   """
   file_extensions: [BAR]
   """
   And a source file 'readme-tester.yaml.dist':
   """
   file_extensions: [FOO]
   """
   And the command line argument '--no-bootstrap'
   When I run readme tester
   Then 1 files are found

  Scenario: I load a custom config file
    Given a source file 'foo.BAR':
    """
    """
    And a source file 'config.yaml':
    """
    file_extensions: [BAR]
    """
    And the command line argument '--no-bootstrap'
    And the command line argument '--config config.yaml'
    When I run readme tester
    Then 1 files are found
