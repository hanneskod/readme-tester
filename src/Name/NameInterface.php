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
    public function getName(): string;

    /**
     * Get the part of name not describing a namespace
     */
    public function getShortName(): string;

    /**
     * Get the namespace part of name
     */
    public function getNamespaceName(): string;
}
