<?php
// Temporary exemplify runner
// cli tool to come...

namespace hanneskod\exemplify;

include __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/tests/ExamplesTest.php";

/*
Finns det en phpunit.xml eller phpunit.xml.dist så
    läsa i vilken katalog testerna ska finnas (om phpunit har ett bra gränssnitt för detta...)
    leta igenom den katalogen efter en klass som ärver Example....
    på detta sätt behövs ingen egen settings-fil för att använda

Stöd för att hämta exempel från flera olika filer

Inställningar som ska kunna göras på cli:
    formattering
        första header-nivå
        radbredd
        indrag för kodavsnitt
    fil att parsa
    katalog från vilken test ska hittas
*/

$test = new ExamplesTest();
$examples = $test->exemplify();

$formatter = new Formatter\MarkdownFormatter();
echo $examples->format($formatter);
