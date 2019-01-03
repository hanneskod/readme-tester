<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Parser;

use hanneskod\readmetester\Utils\CodeBlock;

class ParserTest extends \PHPUnit\Framework\TestCase
{
    function testReadmeWithNoExamples()
    {
        $this->assertEquals(
            [],
            (new Parser)->parse('no-examples-here..')
        );
    }

    function testExample()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code goes here\n"))
            ],
            (new Parser)->parse(<<<'README'
```php
// code goes here
```
README
            )
        );
    }

    function testExampleMultipelLines()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("\$a = new Class();\necho \$a->out();\n"))
            ],
            (new Parser)->parse(<<<'README'
```php
$a = new Class();
echo $a->out();
```
README
            )
        );
    }

    function testEmbeddedExample()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code goes here\n"))
            ],
            (new Parser)->parse(<<<'README'
Some none example text..

```php
// code goes here
```

More free text..
README
            )
        );
    }

    function testMultipleExamples()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code goes here\n")),
                new Definition(new CodeBlock("// second example\n"))
            ],
            (new Parser)->parse(<<<'README'
```php
// code goes here
```

Free text..

```php
// second example
```
README
            )
        );
    }

    function testExampleStartCaseInsensivity()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code goes here\n"))
            ],
            (new Parser)->parse(<<<'README'
```PHP
// code goes here
```
README
            )
        );
    }

    function testSingleAnnotation()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!-- @foo bar -->
```php
```
README
            )
        );
    }

    function testManySingleAnnotations()
    {
        $this->assertEquals(
            [
                new Definition(
                    new CodeBlock(''), new Annotation('foo', 'bar'), new Annotation('bar', 'foo')
                )
            ],
            (new Parser)->parse(<<<'README'
<!-- @foo bar -->
<!-- @bar foo -->
```php
```
README
            )
        );
    }

    function testMultipleAnnotations()
    {
        $this->assertEquals(
            [
                new Definition(
                    new CodeBlock(''), new Annotation('foo', 'bar'), new Annotation('bar', 'foo')
                )
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar
    @bar foo
-->
```php
```
README
            )
        );
    }

    function testMultipleAnnotationsOddSpacing()
    {
        $this->assertEquals(
            [
                new Definition(
                    new CodeBlock(''), new Annotation('foo', 'bar'), new Annotation('bar', 'foo')
                )
            ],
            (new Parser)->parse(" \t<!-- \t\n@foo bar\n@bar foo --> \t\n```php\n```")
        );
    }

    function testMultipleAnnotationArguments()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', 'baz'))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar baz
-->
```php
```
README
            )
        );
    }

    function testQuotedAnnotationArgument()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', "baz 'baz'"))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar "baz 'baz'"
-->
```php
```
README
            )
        );
    }

    function testEmptyAnnotationArguments()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', '', ''))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar "" ''
-->
```php
```
README
            )
        );
    }

    function testQuotedAnnotationArgumentWithSpace()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar baz'))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo "bar baz"
-->
```php
```
README
            )
        );
    }

    function testEscapedQuoteInAnnotationArgument()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', '"'))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar "\""
-->
```php
```
README
            )
        );
    }

    function testSingleQuotedAnnotationArgument()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', '"baz baz"'))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar '"baz baz"'
-->
```php
```
README
            )
        );
    }

    function testEscapedSingleQuoteInAnnotationArgument()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar', "'"))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar '\''
-->
```php
```
README
            )
        );
    }

    function testAnnotationWithNoArgument()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo'))
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo
-->
```php
```
README
            )
        );
    }

    function testAnnotationWithNoSpacing()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!--@foo bar-->
```php
```
README
            )
        );
    }

    function testColdFusionCommentStyle()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!--- @foo bar --->
```php
```
README
            )
        );
    }

    function testEmptyLineBetweenAnnotationsAndExample()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!-- @foo bar -->

```php
```
README
            )
        );
    }

    function testAnnotationsIgnoredWhenNotNextToExample()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''))
            ],
            (new Parser)->parse(<<<'README'
<!-- @foo bar -->
Content between annotation and code ignores annotation...
```php
```
README
            )
        );
    }

    function testEmptyLinesInAnnotationBlock()
    {
        $this->assertEquals(
            [
                new Definition(
                    new CodeBlock(''),
                    new Annotation('foo', 'bar'),
                    new Annotation('bar', 'foo')
                )
            ],
            (new Parser)->parse(<<<'README'
<!--

@foo bar

@bar foo

-->
```php
```
README
            )
        );
    }

    function testFreeTextInAnnotationBlock()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock(''), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!--
Ignored text describing this example...

@foo bar
-->
```php
```
README
            )
        );
    }

    function testHiddenCodeBlock()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code\n"))
            ],
            (new Parser)->parse(<<<'README'
<!--
```php
// code
```
-->
README
            )
        );
    }

    function testHiddenCodeBlockWithAnnotation()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code\n"), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!--
@foo bar
```php
// code
```
-->
README
            )
        );
    }

    function testHiddenCodeBlockWithMultipleAnnotations()
    {
        $this->assertEquals(
            [
                new Definition(
                    new CodeBlock("// code\n"), new Annotation('foo', 'bar'), new Annotation('bar', 'foo')
                )
            ],
            (new Parser)->parse(<<<'README'
<!--
@foo bar
@bar foo
```php
// code
```
-->
README
            )
        );
    }

    function testHiddenCodeBlockWithNewlinesInsideComment()
    {
        $this->assertEquals(
            [
                new Definition(new CodeBlock("// code\n"), new Annotation('foo', 'bar'))
            ],
            (new Parser)->parse(<<<'README'
<!--

@foo bar

```php
// code
```

-->
README
            )
        );
    }
}
