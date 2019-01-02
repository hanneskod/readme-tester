<?php

namespace hanneskod\readmetester\Name;

interface NameInterface
{
    /**
     * Namespace/short name delimiter
     */
    const NAME_DELIMITER = ':';

    /**
     * Get the complete name
     */
    public function getCompleteName(): string;

    /**
     * Get the part of name not describing a namespace
     */
    public function getShortName(): string;

    /**
     * Get the namespace part of name
     */
    public function getNamespaceName(): string;

    /**
     * Check if this name equals $name
     */
    public function equals(NameInterface $name): bool;

    /**
     * Check if name is to be regarded as void
     */
    public function isUnnamed(): bool;
}
