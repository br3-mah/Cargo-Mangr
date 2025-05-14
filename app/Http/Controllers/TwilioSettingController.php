<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TwilioSetting;
use Illuminate\Support\Facades\Validator;

class TwilioSettingController extends Controller
{

    public function index()
    {
        $setting = TwilioSetting::first();
        $adminTheme = env('ADMIN_THEME', 'adminLte');

        return view('cargo::' . $adminTheme . '.pages.settings.twilio.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_sid' => 'required|string',
            'auth_token' => 'required|string',
            'from_number' => 'required|string',
            'enabled' => 'nullable|boolean',
        ]);

        TwilioSetting::updateOrCreate(['id' => 1], $validated);

        return redirect()->back()->with('success', 'Twilio settings updated successfully.');
    }

}