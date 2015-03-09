<?php

namespace hanneskod\readmetester;

class FileInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContent()
    {
        $this->assertRegExp(
            '/FileInfoTest/',
            (new FileInfo(__FILE__))->getContents()
        );
    }
}
