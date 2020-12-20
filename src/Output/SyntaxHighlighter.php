<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Output;

class SyntaxHighlighter
{
    private const REPLACEMENTS = [
        '/&nbsp;/' => ' ',
        '/<\/?code>/' => '',
        '/&lt;\?php /' => '',
        '/<span style="color: ([^"]+)">/' => '<fg=$1>',
        '/<\/span>/' => '</>',
        '/<fg=[^>]+>\s*<\/>/' => '',
        "/\r|\n/" => '',
        '/<br\s*\/>/' => "\n",
    ];

    public function __construct(
        private string $stringColor = '',
        private string $commentColor = '',
        private string $keywordColor = '',
        private string $defaultColor = '',
        private string $htmlColor = '',
    ) {
        if ($stringColor) {
            ini_set('highlight.string', $stringColor);
        }

        if ($commentColor) {
            ini_set('highlight.comment', $commentColor);
        }

        if ($keywordColor) {
            ini_set('highlight.keyword', $keywordColor);
        }

        if ($defaultColor) {
            ini_set('highlight.default', $defaultColor);
        }

        if ($htmlColor) {
            ini_set('highlight.html', $htmlColor);
        }
    }

    public function highlight(string $code): string
    {
        return html_entity_decode(
            (string)preg_replace(
                array_keys(self::REPLACEMENTS),
                self::REPLACEMENTS,
                highlight_string('<?php ' . $code, true)
            )
        );
    }
}
