<?php
namespace hanneskod\exemplify;

include __DIR__ . "/vendor/autoload.php";

$config = new Config\Configuration('phpunit.xml.dist');

$classes = array_merge(
    Config\ClassFinder::find('tests/ExamplesTest.php'),
    Config\ClassFinder::find($config->getTestFiles())
);

echo getContent($classes);

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

function getContent(array $classnames) {
    $container = new Content\Container;
    $container->addContent(new Content\Header('HEADER'));

    foreach ($classnames as $class) {
        $obj = new $class();
        $container->addContent($obj->exemplify());
    }

    return $container->format(new Formatter\MarkdownFormatter);
}
