<?php
namespace hanneskod\exemplify;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException hanneskod\exemplify\Exception
     */
    public function testGetAnnotationException()
    {
        $stub = $this->getMockBuilder('hanneskod\exemplify\Example')
                     ->disableOriginalConstructor()
                     ->setMethods(array('hasAnnotation', 'getName'))
                     ->getMock();

        $stub->expects($this->once())
            ->method('hasAnnotation')
            ->with('tag')
            ->will($this->returnValue(false));

        $stub->getAnnotation('tag');
    }
}
