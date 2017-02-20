<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * The data defining an example
 */
class Definition
{
    /**
     * @var array The set of annotations
     */
    private $annotations;

    /**
     * @var CodeBlock Example code
     */
    private $code;

    public function __construct(array $annotations, CodeBlock $code)
    {
        $this->annotations = $annotations;
        $this->code = $code;
    }

    public function getCodeBlock(): CodeBlock
    {
        return $this->code;
    }

    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * Check if annotation $needle exists
     */
    public function isAnnotatedWith(string $needle): bool
    {
        foreach ($this->getAnnotations() as list($name, $args)) {
            if (strcasecmp($name, $needle) == 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Read the first argument from annotation $needle
     */
    public function readAnnotation(string $needle): string
    {
        foreach ($this->getAnnotations() as list($name, $args)) {
            if (strcasecmp($name, $needle) == 0) {
                return isset($args[0]) ? $args[0] : '';
            }
        }

        return '';
    }
}
