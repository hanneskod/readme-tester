<?php

namespace hanneskod\readmetester;

class SourceFileIteratorTest extends \PHPUnit\Framework\TestCase
{
    const PROJECT_ROOT = __DIR__ . '/..';

    function testSingleFile()
    {
        $this->assertCount(1, iterator_to_array(new SourceFileIterator(self::PROJECT_ROOT . '/README.md')));
    }

    function testSourceContentReturned()
    {
        $this->assertSame(
            file_get_contents(self::PROJECT_ROOT . '/README.md'),
            iterator_to_array(new SourceFileIterator(self::PROJECT_ROOT . '/README.md'))['README.md']
        );
    }

    function testExceptionIfFileDoesNotExist()
    {
        $this->expectException(\Exception::CLASS);
        iterator_to_array(new SourceFileIterator('this-is-not-a-valid-file-name'));
    }

    function testDirectory()
    {
        $this->assertCount(1, iterator_to_array(new SourceFileIterator(self::PROJECT_ROOT)));
    }
}
