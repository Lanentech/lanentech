<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command;

use App\Tests\TestCase\IntegrationTestCase;

class BaseTestCommand extends IntegrationTestCase
{
    /**
     * The output from the Symfony commands have lots of line breaks in them, which means it's difficult to
     * assert on when matching strings. Therefore, this method cleans up the line breaks and then removes any
     * excessive spacing in the output. This helps to assert on the string as a whole.
     */
    protected function cleanOutput(string $output): string
    {
        return trim(preg_replace('/\s+/', ' ', str_replace(["\n", "\r", "\t"], '', $output)));
    }
}
