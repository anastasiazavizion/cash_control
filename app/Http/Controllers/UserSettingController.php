<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSettingRequest;
use Illuminate\Support\Facades\Auth;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Auth::user()->settings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserSettingRequest $request)
    {
        Auth::user()->settings()->updateOrCreate(
            ['user_id' => Auth::id()],
            $request->validated()
        );
        return response()->json(['message'=>'Settings saved']);
    }

}
