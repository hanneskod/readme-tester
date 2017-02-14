<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * Wrapps an executable block of code
 */
class CodeBlock
{
    /**
     * @var string The contained code
     */
    private $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Grab contained code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Execute code block
     *
     * @return Result The result of the executed code
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
