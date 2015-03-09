<?php

namespace hanneskod\readmetester;

class RegexpTest extends \PHPUnit_Framework_TestCase
{
    public function regexpProvider()
    {
        return array(
            array('/test/', 'a test'),
            array('#delimiter#', 'a different delimiter'),
            array('foobar', 'foobar')
        );
    }

    /**
     * @dataProvider regexpProvider
     */
    public function testMatch($regexp, $subject)
    {
        $this->assertTrue(
            (new Regexp($regexp))->isMatch($subject)
        );
    }

    public function testNoMatch()
    {
        $this->assertFalse(
            (new Regexp('foo'))->isMatch('bar')
        );
    }

    public function testToString()
    {
        $this->assertSame(
            '/^foo$/',
            (string)new Regexp('foo')
        );
    }
}
