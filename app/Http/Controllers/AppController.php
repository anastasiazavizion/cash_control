<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
class AppController extends Controller
{
    public function getLogo(): JsonResponse
    {
        return response()->json(Storage::temporaryUrl('logo/logo.png', now()->addMinutes(10)));

    }
}
