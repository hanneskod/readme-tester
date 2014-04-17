<?php
namespace hanneskod\exemplify;

class TestCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testExemplify()
    {
        $case = new SimpleExample();

        $this->assertEquals(
            new Content\Container(
                new Content\Header('Phpunit test case'),
                new Content\TextContent('These last lines are for internal unit testing...'),
                new Content\Container(
                    new Content\VoidContent(),
                    new Content\VoidContent(),
                    new Content\CodeBlock(array()),
                    new Content\VoidContent()
                ),
                new Content\Container(
                    new Content\Header('Example header'),
                    new Content\TextContent('Example before'),
                    new Content\CodeBlock(array("        // code\n")),
                    new Content\TextContent('Example after')
                ),
                new Content\Container(
                    new Content\VoidContent(),
                    new Content\TextContent('Example before'),
                    new Content\CodeBlock(array()),
                    new Content\VoidContent()
                )
            ),
            $case->exemplify()
        );
    }
}

/**
 * Phpunit test case
 *
 * These last lines are for internal unit testing...
 */
class SimpleExample extends TestCase
{
    public function exampleOne()
    {
    }

    /**
     * Example header
     *
     * Example before
     *
     * @after Example after
     */
    public function exampleTwo()
    {
        // code
    }

    /**
     * @before Example before
     */
    public function exampleThree()
    {
    }
}
