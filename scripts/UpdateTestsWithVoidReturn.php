<?php

declare(strict_types=1);

$testsDirectory = __DIR__ . '/../tests/';

// Regular expression pattern to find 'test' functions without ': void' at the end.
$pattern = '/(function\s+test\w*\s*\([^)]*\))(?!\s*:\s*void\s*)(\s*){/';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($testsDirectory));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());

        // Find 'test' functions without ': void' and add it with the brace on the next line.
        $updatedContent = preg_replace($pattern, '\1: void\2{', $content);

        file_put_contents($file->getPathname(), $updatedContent);
    }
}
