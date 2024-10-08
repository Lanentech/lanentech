<?php

declare(strict_types=1);

namespace App\Twig;

use App\Exception\PriceFormattingException;
use App\Helper\Price\PriceFormatterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PriceExtension extends AbstractExtension
{
    public function __construct(
        private readonly PriceFormatterInterface $priceFormatter,
    ) {
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice(string $price): string|float
    {
        try {
            return $this->priceFormatter->priceToFloat($price);
        } catch (PriceFormattingException) {
            return 'Divide by zero error during formatting';
        }
    }
}
