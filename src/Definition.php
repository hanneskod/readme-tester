<?php

declare(strict_types = 1);

namespace hanneskod\readmetester;

/**
 * Wrapper around the code and annotations defining an example
 */
class Definition
{
    /**
     * @var Annotation[] The set of annotations
     */
    private $annotations;

    /**
     * @var CodeBlock Example code
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

    /**
     * Get annotation matching $name
     */
    public function getAnnotation(string $name): Annotation
    {
        foreach ($this->getAnnotations() as $annotation) {
            if ($annotation->isNamed($name)) {
                return $annotation;
            }
        }

        throw new \LogicException("Annotation $name does not exist");
    }

    /**
     * Check if annotation $name exists
     */
    public function isAnnotatedWith(string $name): bool
    {
        foreach ($this->getAnnotations() as $annotation) {
            if ($annotation->isNamed($name)) {
                return true;
            }
        }

        return false;
    }
}
