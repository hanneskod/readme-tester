<?php

namespace hanneskod\readmetester\Format;

class MarkdownTest extends \PHPUnit_Framework_TestCase
{
    private $markdown;

    public function setUp()
    {
        $this->markdown = new Markdown;
    }

    public function testName()
    {
        $this->assertSame(
            'Markdown',
            $this->markdown->getName()
        );
    }

    public function testIsExampleStart()
    {
        $this->assertTrue(
            $this->markdown->isExampleStart('```php ')
        );
        $this->assertFalse(
            $this->markdown->isExampleStart('```bash')
        );
    }

    public function testIsExampleEnd()
    {
        $this->assertTrue(
            $this->markdown->isExampleEnd('``` ')
        );
        $this->assertFalse(
            $this->markdown->isExampleEnd('')
        );
    }
}
