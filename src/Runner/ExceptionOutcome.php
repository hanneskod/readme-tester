<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Exception from an executed code block
 */
class ExceptionOutcome implements OutcomeInterface
{
    /**
     * @var array
     */
    private $payload;

    public function __construct(string $class, string $message, int $code)
    {
        $this->payload = [
            'class' => $class,
            'message' => $message,
            'code' => $code
        ];
    }

    public function getType(): string
    {
        return self::TYPE_EXCEPTION;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function __tostring(): string
    {
        return "exception '{$this->payload['class']}'";
    }
}
