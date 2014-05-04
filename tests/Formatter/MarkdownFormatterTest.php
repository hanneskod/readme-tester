<?php
namespace hanneskod\exemplify\Formatter;

class MarkdownFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatHeader()
    {
        $formatter = new MarkdownFormatter(2);
        $this->assertEquals("## header\n\n", $formatter->formatHeader('header'));

        $formatter->levelUpHeader();
        $this->assertEquals("### header\n\n", $formatter->formatHeader('header'));

        $formatter->levelDownHeader();
        $this->assertEquals("## header\n\n", $formatter->formatHeader('header'));
    }

    public function testFormatText()
    {
        $formatter = new MarkdownFormatter(1, 10);

        $this->assertEquals("Foo bar\n\n", $formatter->formatText('Foo    bar'));
        $this->assertEquals("Foo bar\n\n", $formatter->formatText("Foo\nbar"));
        $this->assertEquals("1234567890\nFoo bar\n\n", $formatter->formatText("1234567890 Foo\nbar"));
    }

    public function testFormatCodeBlock()
    {
        $formatter = new MarkdownFormatter(1, 10, '**');

        $lines = array(
            "    one\n",
            "",
            "    ",
            "    two\n"
        );
        $this->assertEquals("```php\n**one\n\n\n**two\n```\n\n", $formatter->formatCodeBlock($lines));

        $lines = array(
            "    one\n",
            "two\n",
        );
        $this->assertEquals("```php\n**    one\n**two\n```\n\n", $formatter->formatCodeBlock($lines));

        $lines = array();
        $this->assertEquals("", $formatter->formatCodeBlock($lines));
    }
}
