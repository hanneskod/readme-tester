<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

final class ConfigurationIncluded extends BaseEvent
{
    private string $filename;

    public function __construct(string $filename)
    {
        parent::__construct("Reading configuration from: $filename");
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
