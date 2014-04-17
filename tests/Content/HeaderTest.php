<?php
namespace hanneskod\exemplify\Content;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $header = 'foobar';

        $formatter = $this->getMock('hanneskod\exemplify\FormatterInterface');
        $formatter->expects($this->once())
            ->method('formatHeader')
            ->with($header)
            ->will($this->returnValue($header));

        $content = new Header($header);
        $this->assertEquals($header, $content->format($formatter));
    }
}
