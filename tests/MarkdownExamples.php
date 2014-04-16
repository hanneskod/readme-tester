<?php
namespace hanneskod\exemplify;

/**
 * Markdown examples
 *
 * A class level docblock can start with a short description, wich will be formatted
 * as a headling, and continue with a long description wich will be formatted
 * as normal text. Regular markdown can be used. We use this to create a link
 * to the [source file for these examples](tests/MarkdownExamples.php).
 */
class MarkdownExample extends TestCase
{
    /**
     * Using the before and after annotations
     * 
     * If you omit the short description exemplify will under some conditions
     * interpret the long description as a headline.
     */
    public function exampleOne()
    {
        // void example
    }    

    /**
     * @before Fix this by using the `@before` annotation. As done in this paragraph.
     * 
     * @after In a simliar manner the `@after` annotation may be used to add
     *     descripticve text after the example code block.
     */
    public function exampleTwo()
    {
        // void example
    }    
}
