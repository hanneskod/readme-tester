<?php

namespace hanneskod\readmetester;

class FileInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContent()
    {
        $info = new FileInfo(__FILE__);
        $this->assertRegExp(
            '/FileInfoTest/',
            $info->getContents()
        );
    }
}
