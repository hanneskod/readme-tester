<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

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
                [
                    'annotations' => [],
                    'code' => "// code goes here\n"
                ]
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
                [
                    'annotations' => [],
                    'code' => "\$a = new Class();\necho \$a->out();\n"
                ]
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
                [
                    'annotations' => [],
                    'code' => "// code goes here\n"
                ]
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
                [
                    'annotations' => [],
                    'code' => "// code goes here\n"
                ],
                [
                    'annotations' => [],
                    'code' => "// second example\n"
                ]
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
                [
                    'annotations' => [],
                    'code' => "// code goes here\n"
                ]
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
                [
                    'annotations' => [['foo', ['bar']]],
                    'code' => ""
                ]
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
                [
                    'annotations' => [
                        ['foo', ['bar']],
                        ['bar', ['foo']]
                    ],
                    'code' => ""
                ]
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
                [
                    'annotations' => [
                        ['foo', ['bar']],
                        ['bar', ['foo']]
                    ],
                    'code' => ""
                ]
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
                [
                    'annotations' => [
                        ['foo', ['bar']],
                        ['bar', ['foo']]
                    ],
                    'code' => ""
                ]
            ],
            (new Parser)->parse(" \t<!-- \t\n@foo bar\n@bar foo --> \t\n```php\n```")
        );
    }

    function testMultipleAnnotationArguments()
    {
        $this->assertEquals(
            [
                [
                    'annotations' => [['foo', ['bar', 'baz']]],
                    'code' => ""
                ]
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
                [
                    'annotations' => [['foo', ['bar', 'baz']]],
                    'code' => ""
                ]
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar "baz"
-->
```php
```
README
            )
        );
    }

    function testEmptyAnnotationArgument()
    {
        $this->assertEquals(
            [
                [
                    'annotations' => [['foo', ['bar', '']]],
                    'code' => ""
                ]
            ],
            (new Parser)->parse(<<<'README'
<!--
    @foo bar ""
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
                [
                    'annotations' => [['foo', ['bar baz']]],
                    'code' => ""
                ]
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
                [
                    'annotations' => [['foo', ['bar', '"']]],
                    'code' => ""
                ]
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

    function testAnnotationWithNoArgument()
    {
        $this->assertEquals(
            [
                [
                    'annotations' => [['foo', []]],
                    'code' => ""
                ]
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
                [
                    'annotations' => [['foo', ['bar']]],
                    'code' => ""
                ]
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
                [
                    'annotations' => [['foo', ['bar']]],
                    'code' => ""
                ]
            ],
            (new Parser)->parse(<<<'README'
<!--- @foo bar -->
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
                [
                    'annotations' => [],
                    'code' => "// code\n"
                ]
            ],
            (new Parser)->parse(<<<'README'
<!-- @foo bar -->
Content between annotation and code ignores annotation...
```php
// code
```
README
            )
        );
    }
}
