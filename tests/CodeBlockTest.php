<?php

namespace hanneskod\readmetester;

class CodeBlockTest extends \PHPUnit_Framework_TestCase
{
    public function testOutput()
    {
        $codeBlock = new CodeBlock('echo "foo"; return "bar";');
        $this->assertSame(
            'foo',
            $codeBlock->execute()->getOutput()
        );
    }

    public function testReturnValue()
    {
        $codeBlock = new CodeBlock('echo "foo"; return 1234;');
        $this->assertSame(
            1234,
            $codeBlock->execute()->getReturnValue()
        );
    }

    public function testException()
    {
        $codeBlock = new CodeBlock('throw new Exception;');
        $this->assertInstanceOf(
            'Exception',
            $codeBlock->execute()->getException()
        );
    }

    public function testVoid()
    {
        $codeBlock = new CodeBlock('$a = 1 + 2;');
        $this->assertInstanceOf(
            'hanneskod\readmetester\Result',
            $codeBlock->execute()
        );
    }
}
