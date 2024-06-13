<?php

declare(strict_types=1);

namespace App\Util\Html;

class HtmlCleaner
{
    public static function minify(string $html): string
    {
        $minifiedHtml = preg_replace(
            [
                '/\s*(<[^>]+>)\s*/', // Remove leading and trailing spaces around tags
                '/\s+/',             // Remove multiple spaces within the text content
                '/\r\n|\r/',         // Normalize line breaks to a single newline character
            ],
            [
                '$1', // Keep the tag intact without surrounding spaces
                ' ',  // Replace multiple spaces with a single space
                "\n", // Replace various line break types with a single newline character
            ],
            $html,
        );

        return $minifiedHtml ?? $html;
    }
}
