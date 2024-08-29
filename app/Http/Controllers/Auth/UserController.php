<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\User\CurrentUserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function user(Request $request)
    {
        return response()->json(['user'=>new CurrentUserResource($request->user())]);
    }
}
