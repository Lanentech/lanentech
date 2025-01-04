<?php

declare(strict_types=1);

namespace App\Tests\Unit\Twig;

use App\Exception\PriceFormattingException;
use App\Helper\Price\PriceFormatterInterface;
use App\Tests\TestCase\UnitTestCase;
use App\Twig\PriceExtension;
use Mockery as m;
use Twig\TwigFilter;

class PriceExtensionTest extends UnitTestCase
{
    private PriceFormatterInterface|m\MockInterface $priceFormatter;

    private PriceExtension $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->priceFormatter = m::mock(PriceFormatterInterface::class);

        $this->sut = new PriceExtension(
            $this->priceFormatter,
        );
    }

    public function testGetFilters(): void
    {
        $filters = $this->sut->getFilters();

        $this->assertEquals(TwigFilter::class, $filters[0]::class);
        $this->assertEquals('price', $filters[0]->getName());
    }

    public function testFormatPrice(): void
    {
        $priceAsString = '12345';
        $priceAsFloat = 123.45;

        $this->priceFormatter->expects()->priceToFloat($priceAsString)->andReturn($priceAsFloat);

        $result = $this->sut->formatPrice($priceAsString);

        $this->assertEquals($priceAsFloat, $result);
    }

    public function testFormatPriceWhenExceptionIsThrown(): void
    {
        $this->priceFormatter->expects('priceToFloat')
            ->andThrows(new PriceFormattingException());

        $result = $this->sut->formatPrice('12345');

        $this->assertEquals('Divide by zero error during formatting', $result);
    }
}
