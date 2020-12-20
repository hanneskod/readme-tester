<?php

namespace hanneskod\readmetester\Attribute;

/**
 * Marker interface for readmetester attributes
 */
interface AttributeInterface
{
    public function asAttribute(): string;
}
