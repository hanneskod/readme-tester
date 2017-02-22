<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

class AnnotationTest extends \PHPUnit\Framework\TestCase
{
    function testGetName()
    {
        $this->assertSame(
            'name',
            (new Annotation('name'))->getName()
        );
    }

    function testIsNamed()
    {
        $annotation = new Annotation('name');

        $this->assertTrue($annotation->isNamed('name'));
        $this->assertTrue($annotation->isNamed('NAME'));
        $this->assertFalse($annotation->isNamed('foo'));
    }

    function testGetArguments()
    {
        $this->assertSame(
            ['foo', 'bar'],
            (new Annotation('', 'foo', 'bar'))->getArguments()
        );
    }

    function testGetFirstArgument()
    {
        $this->assertSame(
            'foo',
            (new Annotation('', 'foo', 'bar'))->getArgument()
        );
    }

    function testGetIndexedArgument()
    {
        $this->assertSame(
            'bar',
            (new Annotation('', 'foo', 'bar'))->getArgument(1)
        );
    }

    function testExceptionWhenArgumentDoesNotExist()
    {
        $this->expectException('LogicException');
        (new Annotation(''))->getArgument(1);
    }
}
