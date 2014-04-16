<?php
namespace hanneskod\exemplify;

include __DIR__ . "/vendor/autoload.php";

// för alla cli-argument, använd så lika phpunit som möjligt...

$config = new Config\Configuration('phpunit.xml.dist'); // vilken fil det är ska hämtas från cli/standards...

$classes = array_merge(
    //Config\ClassFinder::find('tests/ExamplesTest.php'), // hämtas från cli
    Config\ClassFinder::find($config->getTestFiles())
);

echo getContent($classes);

function getContent(array $classnames) {
    // Hämta inställningar från cli...
    $formatter = new Formatter\MarkdownFormatter;
    $formatter->levelDownHeader(); // Needed since content is wrapped in container

    $container = new Content\Container;

    // header hämtas från cli
    $header = "Exemplify usage examples";
    if ($header) {
        $container->addContent(new Content\Header($header));
    } else {
        $formatter->levelDownHeader();
    }

    foreach ($classnames as $class) {
        $obj = new $class();
        $container->addContent($obj->exemplify());
    }

    return $container->format($formatter);
}
