<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace hanneskod\exemplify\Config;

use hanneskod\exemplify\Exception;
use File_Iterator_Facade;
use ReflectionClass;

/**
 * ClassFinder is responsible for identifying exemplify classes in files
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ClassFinder
{
    /**
     * @param  string|array $files File or directory names
     * @throws Exception if unvalid fs entity is used
     * @return array
     */
    public static function find($files)
    {
        if (!is_array($files)) {
            $files = (array)$files;
        }

        $classes = array();

        foreach ($files as $filename) {
            if (is_dir($filename)) {
                self::getClassesInDir($filename, $classes);
            } elseif (is_file($filename)) {
                self::getClassesInFile($filename, $classes);
            } else {
                throw new Exception("Unvalid FS pointer <$filename>.");
            }
        }

        return $classes;
    }

    private static function getClassesInDir($dirname, array &$classes)
    {
        $fileIteratorFacade = new File_Iterator_Facade;
        foreach ($fileIteratorFacade->getFilesAsArray($dirname) as $filename) {
            self::getClassesInFile($filename, $classes);
        }
    }

    private static function getClassesInFile($filename, array &$classes)
    {
        $oldClasses = get_declared_classes();
        include_once $filename;
        $newClasses = array_values(array_diff(get_declared_classes(), $oldClasses));

        foreach ($newClasses as $className) {
            $class = new ReflectionClass($className);
            if (!$class->isAbstract()) {
                if ($class->isSubclassOf('\hanneskod\exemplify\TestCase')) {
                    $classes[] = $class->getName();
                }
            }
        }
    }
}
