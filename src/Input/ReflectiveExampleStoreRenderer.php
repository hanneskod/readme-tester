<?php

declare(strict_types = 1);

namespace hanneskod\readmetester\Input;

use hanneskod\readmetester\Example\ExampleStoreInterface;

class ReflectiveExampleStoreRenderer
{
    public function render(ReflectiveExampleStoreTemplate $template): ExampleStoreInterface
    {
        $filename = tempnam(sys_get_temp_dir(), 'readmetester');

        if (!$filename) {
            throw new \LogicException("Unable to generate temporary name");
        }

        file_put_contents($filename, '<?php ' . $template->getCode());

        $error = '';

        set_error_handler(function ($errno, $errstr) use (&$error) {
            $error = $errstr;
        });

        try {
            $exampleStore = @include $filename;
        } catch (\Throwable $e) {
            throw new \RuntimeException("Unable to render example: {$e->getMessage()}");
        }

        restore_error_handler();

        if ($error) {
            throw new \RuntimeException("Unable to render example: $error");
        }

        unlink($filename);

        if (!$exampleStore instanceof ExampleStoreInterface) {
            throw new \LogicException("Invalid return from generated example store");
        }

        return $exampleStore;
    }
}
