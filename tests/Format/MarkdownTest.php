<?php

namespace hanneskod\readmetester\Format;

class MarkdownTest extends \PHPUnit_Framework_TestCase
{
    public function testIsExampleStart()
    {
        $this->assertTrue(
            (new Markdown)->isExampleStart('```php ')
        );
        $this->assertFalse(
            (new Markdown)->isExampleStart('```bash')
        );
    }

    public function testIsExampleEnd()
    {
        $this->assertTrue(
            (new Markdown)->isExampleEnd('``` ')
        );
        $this->assertFalse(
            (new Markdown)->isExampleEnd('')
        );
    }
}
