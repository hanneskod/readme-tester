<?php

declare(strict_types=1);

namespace hanneskod\readmetester\Output;

use hanneskod\readmetester\Event;
use Symfony\Component\Console\Output\OutputInterface;

final class DebugOutputtingSubscriber extends DefaultOutputtingSubscriber
{
    private SyntaxHighlighter $highlighter;

    public function __construct()
    {
        $this->highlighter = new SyntaxHighlighter(
            commentColor: "#797979",
            keywordColor: "yellow",
            stringColor: "cyan",
            defaultColor: 'white',
            htmlColor: 'blue',
        );
    }

    public function onExecutionStarted(Event\ExecutionStarted $event): void
    {
        // Debug is always very verbose
        $event->getOutput()->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        // Bypass highlighter if not decorated (eg. --no-ansi) as highlighter could be unstable
        if (!$event->getOutput()->isDecorated()) {
            $this->highlighter = new VoidSyntaxHighlighter();
        }

        parent::onExecutionStarted($event);
    }

    public function onEvaluationStarted(Event\EvaluationStarted $event): void
    {
        $this->examplePassed = true;
        $this->exampleCount++;

        $this->getOutput()->writeln(
            "\n<fg=green;options=underscore>{$event->getOutcome()->getExample()->getName()->getFullName()}</>"
        );

        $this->getOutput()->writeln("Attributes:");

        foreach ($event->getOutcome()->getExample()->getAttributes() as $attribute) {
            $this->getOutput()->writeln(
                $this->highlighter->highlight($attribute->asAttribute())
            );
        }

        $this->getOutput()->writeln("\nResulted in code:");

        $this->getOutput()->writeln(
            $this->highlighter->highlight(trim($event->getOutcome()->getExample()->getCodeBlock()->getCode()))
        );

        $this->getOutput()->writeln(
            sprintf(
                "\nGenerated outcome:\n<comment>%s</comment>",
                trim($event->getOutcome()->getContent())
            )
        );

        $this->getOutput()->write("\nPerformed tests:");
    }

    public function onEvaluationDone(Event\EvaluationDone $event): void
    {
        $this->getOutput()->writeln('');
    }
}
