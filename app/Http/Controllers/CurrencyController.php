<?php

namespace App\Http\Controllers;

use App\Models\PaymentCurrency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json(PaymentCurrency::all());
    }
}
