<?php

declare(strict_types=1);

namespace App\Helper\Price;

use App\Exception\PriceFormattingException;
use DivisionByZeroError;

class PriceFormatter implements PriceFormatterInterface
{
    public function priceToFloat(int|string $price, string $divideBy = '100', int $precision = 2): float
    {
        if (is_int($price)) {
            $price = (string) $price;
        }

        try {
            return (float) bcdiv($price, $divideBy, $precision);
        } catch (DivisionByZeroError $e) {
            throw new PriceFormattingException('Divide by zero error', previous: $e);
        }
    }
}
