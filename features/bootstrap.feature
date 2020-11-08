Feature: Bootstrap argument
  In order to access the tested source
  As a user
  I need to be able to load a bootstrap file

  Scenario: I use a bootstrap
    Given a source file 'Foo.php':
    """
    <?php
    class Foo
    {
        function out()
        {
            echo 'foo';
        }
    }
    """
    And a markdown file:
    """
    #[ReadmeTester\ExpectOutput('foo')]
    ```php
    (new Foo)->out();
    ```
    """
    And the command line argument '--bootstrap=Foo.php'
    When I run readme tester
    Then 1 expectations are found
    And 0 failures are found
