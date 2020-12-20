<?php

// phpcs:disable PSR1.Files.SideEffects

declare(strict_types=1);

namespace hanneskod\readmetester\Attribute;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_ALL)]
class Isolate extends AbstractAttribute
{
}
