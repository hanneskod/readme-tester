<?php

declare(strict_types=1);

namespace spec\hanneskod\readmetester\Output;

use hanneskod\readmetester\Output\VoidSyntaxHighlighter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VoidSyntaxHighlighterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VoidSyntaxHighlighter::class);
    }

    function it_does_not_highligt()
    {
        $this->highlight("//comment")->shouldReturn("//comment");
    }
}
