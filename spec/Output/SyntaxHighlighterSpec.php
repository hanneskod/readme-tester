<?php
declare(strict_types = 1);

namespace spec\hanneskod\readmetester\Output;

use hanneskod\readmetester\Output\SyntaxHighlighter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SyntaxHighlighterSpec extends ObjectBehavior
{
    private $STRING = 'black';
    private $COMMENT = 'red';
    private $KEYWORD = 'green';
    private $DEFAULT = 'yellow';
    private $HTML = 'blue';

    function let()
    {
        $this->beConstructedWith(
            $this->STRING,
            $this->COMMENT,
            $this->KEYWORD,
            $this->DEFAULT,
            $this->HTML,
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SyntaxHighlighter::class);
    }

    function it_highlights_empty_string()
    {
        $this->highlight("")->shouldReturnConsoleString(
            "<fg={$this->HTML}></>"
        );
    }

    function it_highlights_comment()
    {
        $this->highlight("//comment")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->COMMENT}>//comment</></>"
        );
    }

    function it_preserves_newlines()
    {
        $this->highlight("//A\n//B")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->COMMENT}>//A\n//B</></>"
        );
    }

    function it_preserves_html_specialchars()
    {
        $this->highlight("//<>")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->COMMENT}>//<></></>"
        );
    }

    function it_highlights_simple_string()
    {
        $this->highlight("echo 'bar';")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->KEYWORD}>echo </><fg={$this->STRING}>'bar'</><fg={$this->KEYWORD}>;</></>"
        );
    }

    function it_highlights_attribute()
    {
        $this->highlight("#[Attr('/\$data/')]")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->KEYWORD}>#[</><fg={$this->DEFAULT}>Attr</>"
            . "<fg={$this->KEYWORD}>(</><fg={$this->STRING}>'/\$data/'</><fg={$this->KEYWORD}>)]</></>"
        );
    }

    function it_highlights_html_mode()
    {
        $this->highlight("?>html")->shouldReturnConsoleString(
            "<fg={$this->HTML}><fg={$this->DEFAULT}>?></>html</>"
        );
    }

    function getMatchers(): array
    {
        return [
            'returnConsoleString' => function ($str, $expected) {
                if ($str != $expected) {
                    throw new \Exception(sprintf(
                        'expected string: [%s], found: [%s]',
                        $expected,
                        $str,
                    ));
                }
                return true;
            },
        ];
    }
}
