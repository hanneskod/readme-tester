<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Parser;

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
}
