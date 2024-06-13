<?php

declare(strict_types=1);

namespace App\Util\Class;

class ClassHelper
{
    public static function getNamespace(string $classFilePath): ?string
    {
        $contents = file_get_contents($classFilePath);

        if (is_string($contents) && preg_match('/namespace\s+([^;]+);/', $contents, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
