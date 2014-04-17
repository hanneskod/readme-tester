<?php
namespace hanneskod\exemplify\Content;

class VoidContentTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = $this->getMock('hanneskod\exemplify\FormatterInterface');
        $content = new VoidContent();
        $this->assertEquals('', $content->format($formatter));
    }
}
