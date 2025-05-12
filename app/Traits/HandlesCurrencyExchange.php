<?php

namespace App\Traits;

use App\Models\CurrencyExchangeRate;

trait HandlesCurrencyExchange
{
    /**
     * Convert the amount from one currency to another using exchange rate.
     *
     * @param float $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float|null
     */
    public function convertCurrency(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        try {
            if ($fromCurrency === $toCurrency) {
                return $amount; // No conversion needed
            }

            $rate = CurrencyExchangeRate::where('from_currency', $fromCurrency)
                ->where('to_currency', $toCurrency)
                ->value('exchange_rate');

            if (!$rate) {
                return null; // No rate found
            }

            return round($amount * $rate, 4);
        } catch (\Throwable $th) {
            return round($amount, 4);
        }
    }
}