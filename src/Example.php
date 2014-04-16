<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify;

use ReflectionMethod;
use phpDocumentor\Reflection\DocBlock;
use hanneskod\exemplify\Expectation\VoidExpectation;
use hanneskod\exemplify\Content\VoidContent;
use hanneskod\exemplify\Content\Header;
use hanneskod\exemplify\Content\TextContent;
use hanneskod\exemplify\Content\CodeBlock;
use hanneskod\exemplify\Content\Container;

/**
 * An Example represent a separate exemplify test method.
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Example
{
    /**
     * List of supported annotations
     */
    private static $annotations = array(
        'expectOutputString' => 'hanneskod\exemplify\Expectation\OutputStringExpectation',
        'expectReturnString' => 'hanneskod\exemplify\Expectation\ReturnStringExpectation',
        'expectOutputRegex' => 'hanneskod\exemplify\Expectation\OutputRegexExpectation',
        'expectReturnRegex' => 'hanneskod\exemplify\Expectation\ReturnRegexExpectation',
        'expectedException' => 'hanneskod\exemplify\Expectation\ExceptionExpectation',
    );

    private $method, $testCase;

    /**
     * @param ReflectionMethod $method   Example test method
     * @param TestCase         $testCase Parent test case
     */
    public function __construct(ReflectionMethod $method, TestCase $testCase)
    {
        $this->method = $method;
        $this->testCase = $testCase;
        $this->docblock = new DocBlock($this->method->getDocComment());
    }

    /**
     * Evaluate example method expectation
     *
     * @return void
     */
    public function runTest()
    {
        $expectation = $this->getExpectation();
        $expectation->start();
        $expectation->evaluate(
            $this->method->invoke($this->testCase)
        );
    }

    /**
     * Get annotation content by name
     *
     * @param  string $name
     * @return string
     * @throws Exception If annotation does not exist
     */
    public function getAnnotation($name)
    {
        if ($this->hasAnnotation($name)) {
            foreach ($this->docblock->getTagsByName($name) as $tag) {
                return $tag->getContent();
            }
        }
        throw new Exception("Annotation <$name> does not exist in <{$this->method->getName()}>.");
    }

    /**
     * Check if annotation exists
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasAnnotation($name)
    {
        return $this->docblock->hasTag($name);
    }

    /**
     * Get expectation for this test method
     *
     * @return ExpectationInterface
     */
    public function getExpectation()
    {
        foreach (self::$annotations as $annotation => $class) {
            if ($this->hasAnnotation($annotation)) {
                return new $class(
                    $this->getAnnotation($annotation),
                    $this->method->getName(),
                    $this->testCase
                );
            }
        }

        return new VoidExpectation();
    }

    /**
     * Get the complete example content
     *
     * @return Container
     */
    public function getContainer()
    {
        return new Container(
            $this->getHeader(),
            $this->getBeforeText(),
            $this->getCodeBlock(),
            $this->getAfterText()
        );
    }

    /**
     * Get example header
     *
     * @return ContentInterface
     */
    public function getHeader()
    {
        if ($short = $this->docblock->getShortDescription()) {
            return new Header($short);
        }
        return new VoidContent();
    }

    /**
     * Get explaining text before code block
     *
     * @return ContentInterface
     */
    public function getBeforeText()
    {
        if ($long = $this->docblock->getLongDescription()->getContents()) {
            return new TextContent($long);
        } elseif ($this->hasAnnotation('before')) {
            return new TextContent($this->getAnnotation('before'));
        }
        return new VoidContent();
    }

    /**
     * Get explaining text after code block
     *
     * @return ContentInterface
     */
    public function getAfterText()
    {
        if ($this->hasAnnotation('after')) {
            return new TextContent($this->getAnnotation('after'));
        }
        return new VoidContent();
    }

    /**
     * Get code body of method
     *
     * @return CodeBlock
     */
    public function getCodeBlock()
    {
        $lines = array_slice(
            file($this->method->getFileName()),
            $this->method->getStartLine(),
            $this->method->getEndLine() - $this->method->getStartLine()
        );

        // Remove first line if curley bracket
        if (preg_match('/^\s*\{\s*$/', $lines[0])) {
            array_shift($lines);
        }

        // Remove last line if curley bracket
        if (preg_match('/^\s*\}\s*$/', end($lines))) {
            array_pop($lines);
        }

        return new CodeBlock($lines);
    }
}
