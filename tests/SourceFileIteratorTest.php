<?php

declare(strict_types = 1);

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
        $fname = self::PROJECT_ROOT . '/README.md';
        $this->assertSame(
            file_get_contents($fname),
            iterator_to_array(new SourceFileIterator($fname))[$fname]
        );
    }

    function testExceptionIfFileDoesNotExist()
    {
        $this->expectException(\Exception::CLASS);
        iterator_to_array(new SourceFileIterator('this-is-not-a-valid-file-name'));
    }

    function testDirectory()
    {
        $this->assertGreaterThan(0, iterator_to_array(new SourceFileIterator(self::PROJECT_ROOT)));
    }
}
