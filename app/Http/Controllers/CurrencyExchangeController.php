<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyExchangeRate;

class CurrencyExchangeController extends Controller
{
    public function updateRates(Request $request)
    {
        $request->validate([
            'exchange_rate' => 'required|numeric|min:0',
        ]);

        $first = CurrencyExchangeRate::first();

        if ($first) {
            $first->update([
                'exchange_rate' => $request->exchange_rate,
            ]);
        }else{
            CurrencyExchangeRate::create([
                'from_currency' => 'USD',
                'to_currency' => 'ZMW',
                'exchange_rate' => $request->exchange_rate,
            ]);
        }
        return redirect()->back()->with('success', 'Currency exchange rate updated successfully!');
    }

    public function reset(Request $request)
    {
        CurrencyExchangeRate::truncate();
        return response()->json(['success' => 'Item deleted successfully.']);
    }

}