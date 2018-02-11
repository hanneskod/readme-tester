<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * Immutable value object representing a block of code
 */
class CodeBlock
{
    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Create a new object with the contents of $codeBlock prepended to this block
     */
    public function prepend(CodeBlock $codeBlock): CodeBlock
    {
        return new CodeBlock(
            sprintf(
                "%s\n%s%s\n%s",
                'ob_start();',
                $codeBlock,
                'ob_end_clean();',
                $this
            )
        );
    }

    public function __tostring(): string
    {
        return $this->code;
    }

    /**
     * Execute code block
     */
    public function execute(): Result
    {
        $returnValue = '';
        $exception = null;

        ob_start();

        try {
            $returnValue = eval($this->code);
        } catch (\Exception $e) {
            $exception = $e;
        }

        return new Result($returnValue, ob_get_clean(), $exception);
    }
}
