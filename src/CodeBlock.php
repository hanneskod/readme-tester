<?php

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

    /**
     * Load code
     *
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Execute code block
     *
     * @return Result The result of the executed code
     */
    public function execute()
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
