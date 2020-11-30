<?php

declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Input;

use hanneskod\readmetester\Input\ReflectiveExampleStoreRenderer;
use hanneskod\readmetester\Input\ReflectiveExampleStoreTemplate;
use hanneskod\readmetester\Example\ExampleObj;
use hanneskod\readmetester\Example\ExampleStoreInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReflectiveExampleStoreRendererSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ReflectiveExampleStoreRenderer::class);
    }

    function it_renders(ReflectiveExampleStoreTemplate $template)
    {
        $template->getCode()->willReturn('
return new class() implements hanneskod\readmetester\Example\ExampleStoreInterface
{
    public function getExamples(): iterable
    {
    }
};
');

        $this->render($template)->shouldHaveType(ExampleStoreInterface::class);
    }

    function it_throws_if_template_does_not_return_store(ReflectiveExampleStoreTemplate $template)
    {
        $template->getCode()->willReturn('return "this-is-not-an-example-store";');

        $this->shouldThrow(\LogicException::class)->duringRender($template);
    }

    function it_throws_on_invalid_code(ReflectiveExampleStoreTemplate $template)
    {
        $template->getCode()->willReturn('this-is-not-valid-php-code');

        $this->shouldThrow(\RuntimeException::class)->duringRender($template);
    }

    function it_throws_on_php_error(ReflectiveExampleStoreTemplate $template)
    {
        $template->getCode()->willReturn('trigger_error("ERROR");');

        $this->shouldThrow(\RuntimeException::class)->duringRender($template);
    }
}
