<?php
namespace hanneskod\exemplify\Content;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = $this->getMock('hanneskod\exemplify\FormatterInterface');
        $formatter->expects($this->once())->method('levelUpHeader');
        $formatter->expects($this->once())->method('levelDownHeader');

        $contentA = $this->getMock('hanneskod\exemplify\ContentInterface');
        $contentA->expects($this->once())
            ->method('format')
            ->with($formatter)
            ->will($this->returnValue('foo'));

        $contentB = $this->getMock('hanneskod\exemplify\ContentInterface');
        $contentB->expects($this->once())
            ->method('format')
            ->with($formatter)
            ->will($this->returnValue('bar'));

        $container = new Container($contentA);
        $container->addContent($contentB);

        $this->assertEquals('foobar', $container->format($formatter));
    }
}
