<?php

namespace hanneskod\readmetester;

class CodeBlockTest extends \PHPUnit_Framework_TestCase
{
    public function testOutput()
    {
        $this->assertSame(
            'foo',
            (new CodeBlock('echo "foo"; return "bar";'))->execute()->getOutput()
        );
    }

    public function testReturnValue()
    {
        $this->assertSame(
            1234,
            (new CodeBlock('echo "foo"; return 1234;'))->execute()->getReturnValue()
        );
    }

    public function testException()
    {
        $this->assertInstanceOf(
            'Exception',
            (new CodeBlock('throw new Exception;'))->execute()->getException()
        );
    }

    public function testVoid()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Result',
            (new CodeBlock('$a = 1 + 2;'))->execute()
        );
    }
}
