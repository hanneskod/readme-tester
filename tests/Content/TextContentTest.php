<?php
namespace hanneskod\exemplify\Content;

class TextContentTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $text = 'foobar';

        $formatter = $this->getMock('hanneskod\exemplify\FormatterInterface');
        $formatter->expects($this->once())
            ->method('formatText')
            ->with($text)
            ->will($this->returnValue($text));

        $content = new TextContent($text);
        $this->assertEquals($text, $content->format($formatter));
    }
}
