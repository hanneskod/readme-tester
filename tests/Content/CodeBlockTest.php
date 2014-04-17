<?php
namespace hanneskod\exemplify\Content;

class CodeBlockTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $lines = array('lines');

        $formatter = $this->getMock('hanneskod\exemplify\FormatterInterface');
        $formatter->expects($this->once())
            ->method('formatCodeBlock')
            ->with($lines)
            ->will($this->returnValue('foobar'));

        $content = new CodeBlock($lines);
        $this->assertEquals('foobar', $content->format($formatter));
    }
}
