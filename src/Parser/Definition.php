<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Parser;

use hanneskod\readmetester\Utils\CodeBlock;

/**
 * Value object containing code and annotations defining an example
 */
class Definition
{
    /**
     * @var Annotation[]
     */
    private $annotations;

    /**
     * @var CodeBlock
     */
    private $code;

    public function __construct(CodeBlock $code, Annotation ...$annotations)
    {
        $this->code = $code;
        $this->annotations = $annotations;
    }

    public function getCodeBlock(): CodeBlock
    {
        return $this->code;
    }

    /**
     * @return Annotation[]
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }
}
