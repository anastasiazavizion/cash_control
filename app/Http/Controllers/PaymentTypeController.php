<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       logs()->info(PaymentType::all());
       return response()->json(PaymentType::all());
    }
}
