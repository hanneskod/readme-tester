<?php
// Temporary exemplify runner
// cli tool to come...

namespace hanneskod\exemplify;

include __DIR__ . "/vendor/autoload.php";


// Under här är koden för att läsa phpunit.xml ...
// Flytta till egen klass.
// Skapa en symfony command så att det blir ordentligt gjort.
// lägg till info om detta till dokumentationen
//      jag måste ju ha den fetaste exemplify-filen om mitt eget projekt =)

$doc = new \DOMDocument();
$doc->load('phpunit.xml.dist'); // även phpunit.xml!!!
$xpath = new \DOMXPath($doc);

$testSuiteNodes = $xpath->query('testsuites/testsuite');

if ($testSuiteNodes->length == 0) {
    $testSuiteNodes = $xpath->query('testsuite');
}

// Let files be class-var
$files = array();

if ($testSuiteNodes->length > 1) {
    foreach ($testSuiteNodes as $testSuiteNode) {
        getTestFiles($testSuiteNode, $files);
    }
} elseif ($testSuiteNodes->length == 1) {
    getTestFiles($testSuiteNodes->item(0), $files);
}

// Check for exemplify classes
$classes = array();
foreach ($files as $file) {
    getExemplifyClasses($file, $classes);
}



// Här kommer koden för att göra själva formatteringen.....
// TODO inställningar kring hur det ska bli med markdown och så...
/*
Stöd för att hämta exempel från flera olika filer

Inställningar som ska kunna göras på cli:
    formattering
        första header-nivå
        radbredd
        indrag för kodavsnitt
    fil att parsa
    katalog från vilken test ska hittas
*/

$container = new \hanneskod\exemplify\Content\Container;
$container->addContent(new \hanneskod\exemplify\Content\Header('HEADER'));

foreach ($classes as $className) {
    $obj = new $className();
    $container->addContent($obj->exemplify());
}

$formatter = new Formatter\MarkdownFormatter();
echo $container->format($formatter);




// Under är hjälparfunktioner som jag mer eller mindre kopierat från
// https://github.com/sebastianbergmann/phpunit/blob/master/src/Framework/TestSuite.php
// https://github.com/sebastianbergmann/phpunit/blob/master/src/Util/Configuration.php

function getExemplifyClasses($filename, array &$exemplifyClasses)
{
    $classes    = get_declared_classes();
    include $filename;
    $newClasses = array_values(array_diff(get_declared_classes(), $classes));

    foreach ($newClasses as $className) {
        $class = new \ReflectionClass($className);
        if (!$class->isAbstract()) {
            if ($class->isSubclassOf('\hanneskod\exemplify\TestCase')) {
                $exemplifyClasses[] = $class->getName();
            }
        }
    }
}

function getTestFiles(\DOMElement $testSuiteNode, array &$files)
{
    $exclude = array();
    foreach ($testSuiteNode->getElementsByTagName('exclude') as $excludeNode) {
        $exclude[] = realpath((string) $excludeNode->nodeValue);
    }

    // inject...
    $fileIteratorFacade = new \File_Iterator_Facade;

    foreach ($testSuiteNode->getElementsByTagName('directory') as $directoryNode) {
        $directory = (string) $directoryNode->nodeValue;

        if (empty($directory)) {
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
                realpath($directory),
                $suffix,
                $prefix,
                $exclude
            )
        );
    }

    foreach ($testSuiteNode->getElementsByTagName('file') as $fileNode) {
        $file = (string) $fileNode->nodeValue;

        if (empty($file)) {
            continue;
        }

        $files = array_merge(
            $files, 
            $fileIteratorFacade->getFilesAsArray(
                realpath($file)
            )
        );
    }
}
