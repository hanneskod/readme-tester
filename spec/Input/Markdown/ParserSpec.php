<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Input\Markdown;

use hanneskod\readmetester\Input\Markdown\Parser;
use hanneskod\readmetester\Input\Definition;
use hanneskod\readmetester\Input\ReflectiveExampleStoreTemplate;
use hanneskod\readmetester\Attribute\Name;
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
        $this->parseContent('no-examples-here..')->shouldBeLike(new ReflectiveExampleStoreTemplate);
    }

    function it_finds_simple_example()
    {
        $this->parseContent(<<<'README'
```php
// code goes here
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(code: "// code goes here\n")]
        ));
    }

    function it_finds_example_with_multipel_lines()
    {
        $this->parseContent(<<<'README'
```php
$a = new Class();
echo $a->out();
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(code: "\$a = new Class();\necho \$a->out();\n")]
        ));
    }

    function it_finds_embedded_example()
    {
        $this->parseContent(<<<'README'
Some none example text..

```php
// code goes here
```

More free text..
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(code: "// code goes here\n")]
        ));
    }

    function it_finds_multiple_examples()
    {
        $this->parseContent(<<<'README'
```php
// code goes here
```

Free text..

```php
// second example
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [
                new Definition(code: "// code goes here\n"),
                new Definition(code: "// second example\n"),
            ]
        ));
    }

    function it_finds_example_insensitive_to_case()
    {
        $this->parseContent(<<<'README'
```PHP
// code goes here
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(code: "// code goes here\n")]
        ));
    }

    function it_finds_global_attribute()
    {
        $this->parseContent(<<<'README'
<!--
#[GlobalAttribute]
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ['#[GlobalAttribute]']
        ));
    }

    function it_finds_compact_global_attribute()
    {
        $this->parseContent(<<<'README'
<!--#[GlobalAttribute]-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ['#[GlobalAttribute]']
        ));
    }

    function it_finds_multiple_global_attributes()
    {
        $this->parseContent(<<<'README'
<!--
#[Foo]
#[Bar]
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ['#[Foo]', '#[Bar]']
        ));
    }

    function it_finds_oddly_formed_global_attribute()
    {
        $this->parseContent(<<<'README'
<!--
#[
GlobalAttribute("foo bar", Bar::class)
]
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ["#[\nGlobalAttribute(\"foo bar\", Bar::class)\n]"]
        ));
    }

    function it_ignores_non_attribute_content_in_block()
    {
        $this->parseContent(<<<'README'
<!--
Ignored

#[Foo]

Ignored

Ignored#[Bar]Ignored

Ignored
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ['#[Foo]', '#[Bar]']
        ));
    }

    function it_sees_only_the_first_block_as_global()
    {
        $this->parseContent(<<<'README'
<!--#[Foo]-->
<!--#[Bar]-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            globalAttributes: ['#[Foo]']
        ));
    }

    function it_is_only_global_if_first_content()
    {
        $this->parseContent(<<<'README'
.
<!--#[Not-vied-as-global-as-it-is-not-first-content-in-file]-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate);
    }

    function it_finds_example_attribute()
    {
        $this->parseContent(<<<'README'
#[Foo]
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]'])]
        ));
    }

    function it_finds_example_attribute_in_block()
    {
        $this->parseContent(<<<'README'
.
<!--
#[Foo]
-->
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]'])]
        ));
    }

    function it_finds_multiple_example_attributes()
    {
        $this->parseContent(<<<'README'
#[Foo]
#[Bar]
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]', '#[Bar]'])]
        ));
    }

    function it_finds_multiple_example_attributes_in_block()
    {
        $this->parseContent(<<<'README'
.
<!--
#[Foo]
#[Bar]
-->
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]', '#[Bar]'])]
        ));
    }

    function it_finds_embeded_example_attributes()
    {
        $this->parseContent(<<<'README'
Some content
before#[Foo]after
More content
#[Bar]

#[Baz]

```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]', '#[Bar]', '#[Baz]'])]
        ));
    }

    function it_finds_embeded_example_attribute_blocks()
    {
        $this->parseContent(<<<'README'
Some content
before<!--#[Foo]-->after
More content
<!--#[Bar]-->

<!--#[Baz]-->

```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]', '#[Bar]', '#[Baz]'])]
        ));
    }

    function it_finds_example_attribute_cold_fusion_comment_style()
    {
        $this->parseContent(<<<'README'
.
<!---
#[Foo]
--->
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]'])]
        ));
    }

    function it_uses_atx_headers_as_name_attribute()
    {
        $this->parseContent(<<<'README'
# H1
## H2
### H3
#### H4 ####
##### H5 #####
###### H6 ######
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(
                attributes: [
                    Name::createAttribute("H1"),
                    Name::createAttribute("H2"),
                    Name::createAttribute("H3"),
                    Name::createAttribute("H4"),
                    Name::createAttribute("H5"),
                    Name::createAttribute("H6"),
                ]
            )]
        ));
    }

    function it_escapes_atx_headers()
    {
        $this->parseContent(<<<'README'
# H"
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: [Name::createAttribute("H\"")])]
        ));
    }

    function it_uses_setext_headers_as_name_attribute()
    {
        $this->parseContent(<<<'README'
H1
==

H2
=

H3
--
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(
                attributes: [
                    Name::createAttribute("H1"),
                    Name::createAttribute("H2"),
                    Name::createAttribute("H3"),
                ]
            )]
        ));
    }

    function it_escapes_setex_headers()
    {
        $this->parseContent(<<<'README'
H"
==
```php
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: [Name::createAttribute("H\"")])]
        ));
    }

    function it_uses_a_header_only_once()
    {
        $this->parseContent(<<<'README'
# Header
```php
Example with name
```
```php
Example with no name
```
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [
                new Definition(
                    attributes: [Name::createAttribute("Header")],
                    code: "Example with name\n"
                ),
                new Definition(code: "Example with no name\n"),
            ]
        ));
    }

    function it_finds_hidden_example()
    {
        $this->parseContent(<<<'README'
<!--
```php
// code goes here
```
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(code: "// code goes here\n")]
        ));
    }

    function it_finds_hidden_example_annotations()
    {
        $this->parseContent(<<<'README'
<!--
#[Foo]
#[Bar]
```php
```
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]', '#[Bar]'])]
        ));
    }

    function it_finds_hidden_example_with_ignored_content()
    {
        $this->parseContent(<<<'README'
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
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: ['#[Foo]'])]
        ));
    }

    function it_finds_multiple_hidden_examples()
    {
        $this->parseContent(<<<'README'
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
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [
                new Definition(attributes: ['#[Foo]'], code: "Foo\n"),
                new Definition(attributes: ['#[Bar]'], code: "Bar\n"),
            ]
        ));
    }

    function it_uses_header_as_name_attribute_for_hidden_example()
    {
        $this->parseContent(<<<'README'
# Header
<!--
```php
Code
```
-->
README
        )->shouldBeLike(new ReflectiveExampleStoreTemplate(
            definitions: [new Definition(attributes: [Name::createAttribute("Header")], code: "Code\n")]
        ));
    }
}
