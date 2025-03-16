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
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/signin')->with('error', 'Authentication failed. Please try again.');
        }

        // Check if user already exists
        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            // If user does not exist, create a new one
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'password' => bcrypt(uniqid()), // Assign a random password
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


        $userRegistrationHelper = new UserRegistrationHelper();
        $response = $userRegistrationHelper->NewUser($user);
        if (!$response['success']) {
            throw new \Exception($response['error_msg']);
        }

        $data = $user->toArray();
        $data['country_code']    = 'ZM';
        $data['code']    = 0;
        $data['user_id'] = $response['user']['id'];
        $data['created_by'] = auth()->check() ? auth()->id() : null;

        $client = new Client();
        $client->fill($data);
        if (!$client->save()) {
            throw new \Exception();
        }
        $client->code = $client->id;
        if (!$client->save()) {
            throw new \Exception();
        }
        event(new AddClient($client));
        Auth::loginUsingId($client->user_id);

        // Send Welcome Email
        Mail::to($client->email)->send(new WelcomeMail($client));
        // Log the user in
        Auth::login($user);

        return redirect('/admin')->with('success', 'Successfully logged in!');
    }
}