<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Markdown;

use hanneskod\readmetester\Markdown\Template;
use hanneskod\readmetester\Markdown\Definition;
use hanneskod\readmetester\Attributes\NamespaceName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Template::CLASS);
    }

    function it_creates_example_code()
    {
        $this->beConstructedWith(
            [],
            [new Definition([], "this-is-the-code")]
        );

        $this->getCode()->shouldContain("this-is-the-code");
    }

    function it_creates_example_attribute()
    {
        $this->beConstructedWith(
            [],
            [new Definition(['FooAttribute("Bar")'], "")]
        );

        $this->getCode()->shouldContain('FooAttribute("Bar")');
    }

    function it_expands_readme_attributes()
    {
        $this->beConstructedWith(
            [],
            [new Definition(['ReadmeTester\Example'], "")]
        );

        $this->getCode()->shouldContain('\hanneskod\readmetester\Attributes\Example');
    }

    function it_includes_global_attributes()
    {
        $this->beConstructedWith(
            ['GlobalAttribute'],
            [new Definition([], "")]
        );

        $this->getCode()->shouldContain('GlobalAttribute');
    }

    function it_includes_default_namespace()
    {
        $this->beConstructedWith(
            [],
            [new Definition([], "")]
        );

        $this->setDefaultNamespace('FooNamespace');

        $this->getCode()->shouldContain(NamespaceName::createAttribute('FooNamespace'));
    }
}
