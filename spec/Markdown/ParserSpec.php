<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Markdown\Parser;
use hanneskod\readmetester\Markdown\Definition;
use hanneskod\readmetester\Markdown\Template;
use hanneskod\readmetester\Attributes\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Parser::class);
    }

    function it_tests_doc_with_no_examples()
    {
        $this->parse('no-examples-here..')->shouldBeLike(new Template([], []));
    }

    function it_finds_simple_example()
    {
        $this->parse(<<<'README'
```php
// code goes here
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([], "// code goes here\n")]
        ));
    }

    function it_finds_example_with_multipel_lines()
    {
        $this->parse(<<<'README'
```php
$a = new Class();
echo $a->out();
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([], "\$a = new Class();\necho \$a->out();\n")]
        ));
    }

    function it_finds_embedded_example()
    {
        $this->parse(<<<'README'
Some none example text..

```php
// code goes here
```

More free text..
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([], "// code goes here\n")]
        ));
    }

    function it_finds_multiple_examples()
    {
        $this->parse(<<<'README'
```php
// code goes here
```

Free text..

```php
// second example
```
README
        )->shouldBeLike(new Template(
            [],
            [
                new Definition([], "// code goes here\n"),
                new Definition([], "// second example\n"),
            ]
        ));
    }

    function it_finds_example_insensitive_to_case()
    {
        $this->parse(<<<'README'
```PHP
// code goes here
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([], "// code goes here\n")]
        ));
    }

    function it_finds_global_attribute()
    {
        $this->parse(<<<'README'
<!--
#[GlobalAttribute]
-->
README
        )->shouldBeLike(new Template(
            ['GlobalAttribute'],
            []
        ));
    }

    function it_finds_compact_global_attribute()
    {
        $this->parse(<<<'README'
<!--#[GlobalAttribute]-->
README
        )->shouldBeLike(new Template(
            ['GlobalAttribute'],
            []
        ));
    }

    function it_finds_multiple_global_attributes()
    {
        $this->parse(<<<'README'
<!--
#[Foo]
#[Bar]
-->
README
        )->shouldBeLike(new Template(
            ['Foo', 'Bar'],
            []
        ));
    }

    function it_finds_oddly_formed_global_attribute()
    {
        $this->parse(<<<'README'
<!--
#[
GlobalAttribute("foo bar", Bar::class)
]
-->
README
        )->shouldBeLike(new Template(
            ["GlobalAttribute(\"foo bar\", Bar::class)\n"],
            []
        ));
    }

    function it_ignores_non_attribute_content_in_block()
    {
        $this->parse(<<<'README'
<!--
Ignored

#[Foo]

Ignored

Ignored#[Bar]Ignored

Ignored
-->
README
        )->shouldBeLike(new Template(
            ['Foo', 'Bar'],
            []
        ));
    }

    function it_sees_only_the_first_block_as_global()
    {
        $this->parse(<<<'README'
<!--#[Foo]-->
<!--#[Bar]-->
README
        )->shouldBeLike(new Template(
            ['Foo'],
            []
        ));
    }

    function it_is_only_global_if_first_content()
    {
        $this->parse(<<<'README'
.
<!--#[Not-vied-as-global-as-it-is-not-first-content-in-file]-->
README
        )->shouldBeLike(new Template(
            [],
            []
        ));
    }

    function it_finds_example_attribute()
    {
        $this->parse(<<<'README'
#[Foo]
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo'], "")]
        ));
    }

    function it_finds_example_attribute_in_block()
    {
        $this->parse(<<<'README'
.
<!--
#[Foo]
-->
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo'], "")]
        ));
    }

    function it_finds_multiple_example_attributes()
    {
        $this->parse(<<<'README'
#[Foo]
#[Bar]
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo', 'Bar'], "")]
        ));
    }

    function it_finds_multiple_example_attributes_in_block()
    {
        $this->parse(<<<'README'
.
<!--
#[Foo]
#[Bar]
-->
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo', 'Bar'], "")]
        ));
    }

    function it_finds_embeded_example_attributes()
    {
        $this->parse(<<<'README'
Some content
before#[Foo]after
More content
#[Bar]

#[Baz]

```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo', 'Bar', 'Baz'], "")]
        ));
    }

    function it_finds_embeded_example_attribute_blocks()
    {
        $this->parse(<<<'README'
Some content
before<!--#[Foo]-->after
More content
<!--#[Bar]-->

<!--#[Baz]-->

```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo', 'Bar', 'Baz'], "")]
        ));
    }

    function it_finds_example_attribute_cold_fusion_comment_style()
    {
        $this->parse(<<<'README'
.
<!---
#[Foo]
--->
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo'], "")]
        ));
    }

    function it_uses_atx_headers_as_name_attribute()
    {
        $this->parse(<<<'README'
# H1
## H2
### H3
#### H4 ####
##### H5 #####
###### H6 ######
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(
                [
                    Name::createAttribute("H1"),
                    Name::createAttribute("H2"),
                    Name::createAttribute("H3"),
                    Name::createAttribute("H4"),
                    Name::createAttribute("H5"),
                    Name::createAttribute("H6"),
                ],
                ""
            )]
        ));
    }

    function it_escapes_atx_headers()
    {
        $this->parse(<<<'README'
# H"
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(
                [Name::createAttribute("H\"")],
                ""
            )]
        ));
    }

    function it_uses_setext_headers_as_name_attribute()
    {
        $this->parse(<<<'README'
H1
==

H2
=

H3
--
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(
                [
                    Name::createAttribute("H1"),
                    Name::createAttribute("H2"),
                    Name::createAttribute("H3"),
                ],
                ""
            )]
        ));
    }

    function it_escapes_setex_headers()
    {
        $this->parse(<<<'README'
H"
==
```php
```
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(
                [Name::createAttribute("H\"")],
                ""
            )]
        ));
    }

    function it_uses_a_header_only_once()
    {
        $this->parse(<<<'README'
# Header
```php
Example with name
```
```php
Example with no name
```
README
        )->shouldBeLike(new Template(
            [],
            [
                new Definition([Name::createAttribute("Header")], "Example with name\n"),
                new Definition([], "Example with no name\n"),
            ]
        ));
    }

    function it_finds_hidden_example()
    {
        $this->parse(<<<'README'
<!--
```php
// code goes here
```
-->
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([], "// code goes here\n")]
        ));
    }

    function it_finds_hidden_example_annotations()
    {
        $this->parse(<<<'README'
<!--
#[Foo]
#[Bar]
```php
```
-->
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo', 'Bar'], "")]
        ));
    }

    function it_finds_hidden_example_with_ignored_content()
    {
        $this->parse(<<<'README'
.
<!--
Ignored

#[Foo]

Ignored
```php
```
Ignored
-->
README
        )->shouldBeLike(new Template(
            [],
            [new Definition(['Foo'], "")]
        ));
    }

    function it_finds_multiple_hidden_examples()
    {
        $this->parse(<<<'README'
.
<!--
#[Foo]
```php
Foo
```
#[Bar]
```php
Bar
```
-->
README
        )->shouldBeLike(new Template(
            [],
            [
                new Definition(['Foo'], "Foo\n"),
                new Definition(['Bar'], "Bar\n"),
            ]
        ));
    }

    function it_uses_header_as_name_attribute_for_hidden_example()
    {
        $this->parse(<<<'README'
# Header
<!--
```php
Code
```
-->
README
        )->shouldBeLike(new Template(
            [],
            [new Definition([Name::createAttribute("Header")], "Code\n")]
        ));
    }
}
