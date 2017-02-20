<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

class DefinitionTest extends \PHPUnit\Framework\TestCase
{
    function testGetCodeBlock()
    {
        $this->assertSame(
            $code = $this->prophesize(CodeBlock::CLASS)->reveal(),
            (new Definition([], $code))->getCodeBlock()
        );
    }

    function testGetAnnotations()
    {
        $this->assertSame(
            $annotations = ['foobar'],
            (new Definition($annotations, $this->createMock(CodeBlock::CLASS)))->getAnnotations()
        );
    }

    function testIsAnnotatedWith()
    {
        $def = new Definition([['foo', []]], $this->createMock(CodeBlock::CLASS));
        $this->assertTrue($def->isAnnotatedWith('foo'));
        $this->assertFalse($def->isAnnotatedWith('bar'));
    }

    function testReadAnnotation()
    {
        $def = new Definition([['foo', []], ['bar', ['baz']]], $this->createMock(CodeBlock::CLASS));

        $this->assertSame(
            '',
            $def->readAnnotation('foo')
        );

        $this->assertSame(
            'baz',
            $def->readAnnotation('bar')
        );

        $this->assertSame(
            '',
            $def->readAnnotation('does-not-exist')
        );
    }
}
