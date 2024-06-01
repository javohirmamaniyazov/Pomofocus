<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Notifications\SetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        $redirectUrl = request()->get('redirect');
        session(['redirect_url' => $redirectUrl]);

        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $userr = Socialite::driver($provider)->stateless()->user();
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        // Check if the user is already registered
        $registeredUser = User::where('email', $userr->getEmail())->first();

        if (!$registeredUser) {
            $userCreated = User::create([
                'email' => $user->getEmail(),
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
                'password' => bcrypt(Str::random(10)),
            ]);

            $userCreated->providers()->create([
                'provider' => $provider,
                'provider_id' => $user->getId(),
                'avatar' => $user->getAvatar(),
            ]);

            // Generate a token for password reset
            $tokenLength = 40; // Adjust the length as needed
            $token = Str::random($tokenLength);

            // Save email and token to password_reset_tokens table
            DB::table('password_reset_tokens')->insert([
                'email' => $user->getEmail(),
                'token' => $token,
                'created_at' => now(),
            ]);

            // Send the set password email
            $userCreated->notify(new SetPasswordNotification($token));

            $redirectUrl = session('redirect_url', 'http://localhost:5173/');
            return redirect()->away($redirectUrl . '?token=' . $token)->with('status', 'Password reset link has been sent to your email. Please check your inbox.');
        }

        // If user is already registered, log them in
        
        if ($registeredUser->hasProviders()) {
            Auth::login($registeredUser);
        }

        $redirectUrl = session('redirect_url', 'http://localhost:5173/');
        return redirect()->away($redirectUrl);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['facebook', 'github', 'google'])) {
            return response()->json(['error' => 'Please login using facebook, github or google'], 422);
        }
    }
}
