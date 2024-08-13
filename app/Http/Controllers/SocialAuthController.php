<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        $userSocial = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(
            ['email'=>$userSocial->getEmail()],
            [
            'name' => $userSocial->getName() ?? $userSocial->getNickname(),
            'email' => $userSocial->getEmail(),
            'password'      => Hash::make(Str::random(6)),
            'provider_name' => $provider,
            'provider_id'   => $userSocial->id,
            'provider_token' => $userSocial->token,
            'avatar' => $userSocial->avatar
        ]);

        Auth::login($user);


        return response()->json(['message' => 'OK'], 200);
    }
}
