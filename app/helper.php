<?php
use App\Models\CurrencyExchangeRate;

if (!function_exists('convert_currency')) {
    function current_x_rate(){

        return CurrencyExchangeRate::first()->exchange_rate ?? 0;

    }
    function convert_currency($amount, $from, $to){
        if ($from === $to) {
            return $amount;
        }

        $rate = CurrencyExchangeRate::first()->exchange_rate;

        if ($rate) {
            return $amount * $rate;
        }

        return $amount; // fallback
    }

}