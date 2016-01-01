<?php

namespace hanneskod\readmetester\Format;

class FormatFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new FormatFactory;
    }

    public function testCreateMarkdown()
    {
        $this->assertInstanceOf(
            'hanneskod\readmetester\Format\Markdown',
            $this->factory->createFormat('Markdown')
        );
    }
}
