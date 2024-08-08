<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $payment_type_id = $data['payment_type_id'];

        $summaries = Payment::with('currency')
            ->select('payment_currency_id', DB::raw('SUM(amount) as total_amount'))
            ->where('payment_type_id',$payment_type_id)
            ->groupBy('payment_currency_id')
            ->get();


        $categories = Payment::with('category.icon')
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('payment_type_id',$payment_type_id)
            ->groupBy('category_id')
            ->get();

        $total = Payment::where('payment_type_id',$payment_type_id)->sum('amount');

        $totalSum = Payment::selectRaw('SUM(CASE WHEN payment_type_id = 1 THEN amount ELSE 0 END) as positive_sum')
            ->selectRaw('SUM(CASE WHEN payment_type_id = 2 THEN amount * -1 ELSE 0 END) as negative_sum')
            ->first();
        $totalSum = $totalSum->positive_sum + $totalSum->negative_sum;

        return response()->json(['summaries'=>$summaries, 'total'=>$total, 'totalSum' => $totalSum, 'categories'=>$categories], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {

        if(Payment::create($request->validated())){
            return response()->json(['message'=>'Payment was added'], 200);
        }

        return response()->json('Error', 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
