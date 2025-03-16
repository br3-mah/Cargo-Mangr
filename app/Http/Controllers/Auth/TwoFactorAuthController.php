<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Str;

class TwoFactorAuthController extends Controller
{
    public function enable(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = Auth::user();

        // Verify password before enabling 2FA
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password.');
        }

        // Generate new 2FA secret if not already set
        if (!$user->two_factor_secret) {
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();

            $user->forceFill([
                'two_factor_secret' => encrypt($secret),
                'two_factor_recovery_codes' => encrypt(json_encode($this->generateRecoveryCodes())),
            ])->save();
        }

        return back()->with('success', 'Two-Factor Authentication enabled successfully.');
    }

    public function disable(Request $request)
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();

        return back()->with('success', 'Two-Factor Authentication disabled successfully.');
    }

    public function regenerate(Request $request)
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode($this->generateRecoveryCodes())),
        ])->save();

        return back()->with('success', 'New recovery codes generated.');
    }

    private function generateRecoveryCodes()
    {
        return collect(range(1, 8))->map(fn () => Str::random(10))->toArray();
    }


    public function showVerifyForm()
    {
        if (!Session::has('2fa:user:id')) {
            return redirect()->route('signin')->withErrors(['email' => 'Unauthorized access.']);
        }

        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view($adminTheme.'.auth.2fa_verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!Session::has('2fa:user:id')) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired.']);
        }

        $user = \App\Models\User::find(Session::get('2fa:user:id'));

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'User not found.']);
        }

        $google2fa = new Google2FA();
        $secret = decrypt($user->two_factor_secret);

        if ($google2fa->verifyKey($secret, $request->otp, 1)) {
            // 2FA verification successful, authenticate the user
            Auth::login($user);
            Session::forget('2fa:user:id');

            return redirect()->intended('/dashboard')->with('success', '2FA verified successfully.');
        }
        
        return back()->withErrors(['otp' => 'Invalid OTP.']);
    }
}