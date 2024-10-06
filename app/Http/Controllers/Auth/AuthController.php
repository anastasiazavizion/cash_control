<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return response()->json('Authenticated', 200);
        }
        return response()->json('Unauthorized', 403);
   }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return response()->json('Logout', 200);
    }
}
