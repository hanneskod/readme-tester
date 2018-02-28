<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Parser;

class CodeBlockTest extends \PHPUnit\Framework\TestCase
{
    function testToString()
    {
        $this->assertSame(
            'foobar',
            (string)new CodeBlock('foobar')
        );
    }

    function testPrepend()
    {
        $this->assertSame(
            "[FOO][BAR]",
            (string)(new CodeBlock('[BAR]'))->prepend(new CodeBlock('[FOO]'))
        );
    }
}
