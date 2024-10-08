<?php

declare(strict_types=1);

namespace App\Tests\Unit\Helper\Currency;

use App\Exception\PriceFormattingException;
use App\Helper\Price\PriceFormatter;
use App\Tests\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\TestWith;

class PriceFormatterTest extends UnitTestCase
{
    private PriceFormatter $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new PriceFormatter();
    }

    #[TestWith([1, '100', 0.01])]
    #[TestWith(['1', '100', 0.01])]
    #[TestWith([10, '100', 0.10])]
    #[TestWith(['10', '100', 0.10])]
    #[TestWith([1000, '100', 10.00])]
    #[TestWith(['1000', '100', 10.00])]
    #[TestWith([15999, '100', 159.99])]
    #[TestWith(['15999', '100', 159.99])]
    #[TestWith([156235, '10', 15623.50])]
    #[TestWith(['156235', '10', 15623.50])]
    public function testCurrencyToFloat(int|string $price, string $divideBy, ?float $expected): void
    {
        $result = $this->sut->priceToFloat($price, $divideBy);

        $this->assertEquals($expected, $result);
    }

    #[TestWith([156235, '0'])]
    #[TestWith(['156235', '0'])]
    public function testCurrencyToFloatThrowsExceptionWhenDividingByZero(int|string $price, string $divideBy): void
    {
        $this->expectException(PriceFormattingException::class);

        $this->sut->priceToFloat($price, $divideBy);
    }
}
