<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyExchangeRate;

class CurrencyExchangeController extends Controller
{
    public function updateRates(Request $request)
    {
        $request->validate([
            'from_currency' => 'required|string',
            'to_currency' => 'required|string|different:from_currency',
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        CurrencyExchangeRate::updateOrCreate(
            [
                'from_currency' => strtolower($request->input('from_currency')),
                'to_currency' => strtolower($request->input('to_currency')),
            ],
            [
                'exchange_rate' => $request->input('exchange_rate'),
            ]
        );

        return redirect()->back()->with('success', 'Currency exchange rate updated successfully!');
    }
}
