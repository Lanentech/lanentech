<?php

declare(strict_types=1);

namespace App\Tests\Unit\Util\Html;

use App\Tests\TestCase\UnitTestCase;
use App\Util\Html\HtmlCleaner;

class HtmlCleanerTest extends UnitTestCase
{
    public function testMinifyHtml(): void
    {
        $htmlWithSpacing = <<<HTML
            <p>You can claim expenses for:</p>
            <ul>
                <li>printing</li>
                <li>
                    computer software if your business makes regular payments to renew the licence 
                    (even if you use it for more than 2 years)
                </li>
            </ul>
            <p>
                You can also claim capital allowances for some integral parts of a building, 
                for example water heating systems.
            </p>
        HTML;

        $minifiedHtml = '<p>You can claim expenses for:</p><ul><li>printing</li><li>computer software if your ' .
            'business makes regular payments to renew the licence (even if you use it for more than 2 years)</li>' .
            '</ul><p>You can also claim capital allowances for some integral parts of a building, for example water ' .
            'heating systems.</p>';

        $result = HtmlCleaner::minify($htmlWithSpacing);

        $this->assertEquals($minifiedHtml, $result);
    }
}
