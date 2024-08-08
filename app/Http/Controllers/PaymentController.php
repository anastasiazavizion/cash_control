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

        $total = Payment::all()->sum('amount');

        return response()->json(['summaries'=>$summaries, 'total'=>$total, 'categories'=>$categories], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
