<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

use hanneskod\readmetester\Parser\CodeBlock;
use Symfony\Component\Process\PhpProcess;
use hkod\frontmatter\Parser;
use hkod\frontmatter\JsonParser;
use hkod\frontmatter\VoidParser;
use hkod\frontmatter\InvertedBlockParser;

/**
 * Execute code in isolation using symfony php-process
 */
class IsolationRunner implements RunnerInterface
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser(
            new JsonParser,
            new VoidParser,
            new InvertedBlockParser
        );
    }

    /**
     * @return OutcomeInterface[]
     */
    public function run(CodeBlock $codeBlock): array
    {
        $process = new PhpProcess(<<<EOF
<?php
try {
    $codeBlock
} catch (Exception \$e) {
    echo "---\n";
    echo json_encode([
        'exception' => [
            'class' => get_class(\$e),
            'message' => \$e->getMessage(),
            'code' => \$e->getCode()
        ]
    ]);
    echo "\n---\n";
}
EOF
        );

        $process->run();
        $outcomes = [];

        if ($errorOutput = $process->getErrorOutput()) {
            $outcomes[] = new ErrorOutcome(trim($errorOutput));
        } elseif ($output = $process->getOutput()) {
            $result = $this->parser->parse($output);

            if ($body = $result->getBody()) {
                $outcomes[] = new OutputOutcome($body);
            }

            if ($exceptionDef = $result->getFrontmatter()['exception'] ?? null) {
                $outcomes[] = new ExceptionOutcome(
                    $exceptionDef['class'],
                    $exceptionDef['message'],
                    $exceptionDef['code']
                );
            }
        }

        return $outcomes;
    }
}
