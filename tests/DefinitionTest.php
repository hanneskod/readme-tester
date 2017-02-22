<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

class DefinitionTest extends \PHPUnit\Framework\TestCase
{
    function testGetCodeBlock()
    {
        $this->assertSame(
            $code = $this->prophesize(CodeBlock::CLASS)->reveal(),
            (new Definition($code))->getCodeBlock()
        );
    }

    function testGetAnnotations()
    {
        $annotationA = $this->createMock(Annotation::CLASS);
        $annotationB = $this->createMock(Annotation::CLASS);
        $this->assertSame(
            [$annotationA, $annotationB],
            (new Definition($this->createMock(CodeBlock::CLASS), $annotationA, $annotationB))->getAnnotations()
        );
    }

    function testIsAnnotatedWith()
    {
        $annotation = $this->prophesize(Annotation::CLASS);
        $annotation->isNamed('foo')->willReturn(true);
        $annotation->isNamed('bar')->willReturn(false);

        $def = new Definition($this->createMock(CodeBlock::CLASS), $annotation->reveal());

        $this->assertTrue($def->isAnnotatedWith('foo'));
        $this->assertFalse($def->isAnnotatedWith('bar'));
    }

    function testGetAnnotation()
    {
        $annotationProphecy = $this->prophesize(Annotation::CLASS);
        $annotationProphecy->isNamed('foo')->willReturn(true);
        $annotation = $annotationProphecy->reveal();

        $def = new Definition($this->createMock(CodeBlock::CLASS), $annotation);

        $this->assertSame(
            $annotation,
            $def->getAnnotation('foo')
        );
    }

    function testExceptionWhenAnnotationDoesNotExist()
    {
        $annotation = $this->prophesize(Annotation::CLASS);
        $annotation->isNamed('foo')->willReturn(false);

        $this->expectException('LogicException');
        (new Definition($this->createMock(CodeBlock::CLASS), $annotation->reveal()))->getAnnotation('foo');
    }
}
