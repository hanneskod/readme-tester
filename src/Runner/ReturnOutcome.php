<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Runner;

/**
 * Return value from an executed code block
 */
class ReturnOutcome implements OutcomeInterface
{
    /**
     * @var array
     */
    private $payload;

    public function __construct(string $value, string $type, string $class)
    {
        $this->payload = [
            'value' => $value,
            'type' => $type,
            'class' => $class
        ];
    }

    public function getType(): string
    {
        return self::TYPE_RETURN;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function __tostring(): string
    {
        return "return value '{$this->payload['value']}'";
    }
}
