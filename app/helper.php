<?php

use App\Models\CurrencyExchangeRate;

if (!function_exists('convert_currency')) {

    function current_x_rate() {
        $rate = CurrencyExchangeRate::first();
        return $rate ? $rate->exchange_rate : 0;
    }

    function convert_currency($amount, $from, $to) {
        if ($from === $to) {
            return $amount;
        }

        $rate = CurrencyExchangeRate::first();
        if ($rate && $rate->exchange_rate) {
            return $amount * $rate->exchange_rate;
        }

        return $amount; // fallback if no rate found
    }

}