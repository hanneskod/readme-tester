<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Event;

final class BootstrapIncluded extends LogEvent
{
    private string $filename;

    public function __construct(string $filename)
    {
        parent::__construct("Including bootstrap: $filename");
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
