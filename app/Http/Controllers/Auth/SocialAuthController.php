<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Modules\Cargo\Http\Helpers\UserRegistrationHelper;
use Modules\Users\Events\UserCreatedEvent;
use Modules\Cargo\Events\AddClient;
use Modules\Cargo\Entities\Client;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the OAuth provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the callback from the OAuth provider.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        try {
            // Attempt to get user from provider
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error("Social Authentication Failed: " . $e->getMessage());
            return redirect('/signin')->with('error', 'Authentication failed. Please try again.');
        }

        // Check if user already exists in DB
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // Create a new user if not found
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()), // Generate a random secure password
                'branch_id' => 1,
                'user_id' => 1,
                'role' => 4,
                'terms_conditions' => true
            ]);
        } else {
            // Update provider details if user exists
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        // Register user using helper
        $userRegistrationHelper = new UserRegistrationHelper();
        $response = $userRegistrationHelper->NewUser($user);

        if (!$response['success']) {
            Log::error("User Registration Failed: " . $response['error_msg']);
            return redirect('/signin')->with('error', 'User registration failed. Please contact support.');
        }

        // Prepare client data
        $data = $user->toArray();
        $data['country_code'] = 'ZM';
        $data['code'] = 0;
        $data['user_id'] = $response['user']['id'];
        $data['created_by'] = auth()->check() ? auth()->id() : null;

        try {
            // Create a new client
            $client = new Client();
            $client->fill($data);

            if (!$client->save()) {
                throw new \Exception('Client creation failed.');
            }

            // Set code as client ID and update
            $client->code = $client->id;
            $client->save();

            // Fire event
            event(new AddClient($client));

            // Log the user in
            Auth::loginUsingId($client->user_id);
        } catch (\Exception $e) {
            Log::error("Client Creation Failed: " . $e->getMessage());
            return redirect('/signin')->with('error', 'An error occurred while creating your profile.');
        }

        // Attempt to send welcome email
        try {
            Mail::to($client->email)->send(new WelcomeMail($client));
        } catch (\Exception $e) {
            Log::error("Welcome Email Failed: " . $e->getMessage());
        }

        // Final login step
        Auth::login($user);

        return redirect('/admin')->with('success', 'Successfully logged in!');
    }

}