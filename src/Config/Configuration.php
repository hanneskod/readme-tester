<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Config;

use DOMDocument;
use DOMXPath;
use DOMNodeList;
use DOMElement;
use File_Iterator_Facade;

/**
 * Parse phpunit configuration file
 *
 * Based on the configuration wrapper in phpunit
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Configuration
{
    private $filename, $filter;

    /**
     * @param  string    $filename XML configuration file to parse
     * @param  string    $filter   Limit fs search to directory or file name
     * @throws Exception if $filter is not a valid fs path
     */
    public function __construct($filename, $filter = null)
    {
        $this->filename = $filename;

        if ($filter) {
            $this->filter = realpath($filter);
            if (!$this->filter) {
                throw new Exception("Invalid FS filter <$filter>.");
            }
        }
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return DOMXPath
     */
    public function getXpath()
    {
        $doc = new DOMDocument();
        $doc->load($this->getFilename());
        return new DOMXPath($doc);
    }

    /**
     * @return DOMNodeList
     */
    public function getTestSuiteNodes()
    {
        $xpath = $this->getXpath();

        $testSuiteNodes = $xpath->query('testsuites/testsuite');

        if (0 == $testSuiteNodes->length) {
            $testSuiteNodes = $xpath->query('testsuite');
        }

        return $testSuiteNodes;
    }

    /**
     * @return array
     */
    public function getTestFiles()
    {
        $files = array();

        foreach ($this->getTestSuiteNodes() as $testSuiteNode) {
            $this->getTestFilesInNode($testSuiteNode, $files);
        }

        return $files;
    }

    /**
     * @param  DOMElement $testSuiteNode
     * @param  array      $classes       Files found will be appended to array
     * @return void
     */
    private function getTestFilesInNode(DOMElement $testSuiteNode, array &$files)
    {
        $exclude = array();

        foreach ($testSuiteNode->getElementsByTagName('exclude') as $excludeNode) {
            $exclude[] = realpath((string) $excludeNode->nodeValue);
        }

        $fileIteratorFacade = new File_Iterator_Facade;

        foreach ($testSuiteNode->getElementsByTagName('directory') as $directoryNode) {
            if (!$directory = $this->filterFSNodeValue($directoryNode->nodeValue)) {
                continue;
            }

            if ($directoryNode->hasAttribute('prefix')) {
                $prefix = (string) $directoryNode->getAttribute('prefix');
            } else {
                $prefix = '';
            }

            if ($directoryNode->hasAttribute('suffix')) {
                $suffix = (string) $directoryNode->getAttribute('suffix');
            } else {
                $suffix = 'Test.php';
            }

            $files = array_merge(
                $files,
                $fileIteratorFacade->getFilesAsArray(
                    $directory,
                    $suffix,
                    $prefix,
                    $exclude
                )
            );
        }

        foreach ($testSuiteNode->getElementsByTagName('file') as $fileNode) {
            if (!$file = $this->filterFSNodeValue($fileNode->nodeValue)) {
                continue;
            }

            $files = array_merge(
                $files, 
                $fileIteratorFacade->getFilesAsArray($file)
            );
        }
    }

    /**
     * @param  string $fsNodeValue
     * @return string
     */
    private function filterFSNodeValue($fsNodeValue)
    {
        $fsNodeValue = (string)$fsNodeValue;

        if (empty($fsNodeValue)) {
            return '';
        }

        $fsNodeValue = realpath($fsNodeValue);
        $filter = preg_quote($this->filter, '/');

        if ($this->filter && !preg_match("/^$filter/", $fsNodeValue)) {
            return '';
        }

        return $fsNodeValue;
    }
}
