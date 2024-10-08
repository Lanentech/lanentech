<?php

declare(strict_types=1);

namespace App\Helper\Price;

use App\Exception\PriceFormattingException;

interface PriceFormatterInterface
{
    /**
     * @throws PriceFormattingException
     */
    public function priceToFloat(int|string $price, string $divideBy = '100', int $precision = 2): float;
}
