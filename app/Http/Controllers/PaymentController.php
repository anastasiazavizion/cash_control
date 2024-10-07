<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentByTypeRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\TotalSumRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(public PaymentRepositoryContract $paymentRepository)
    {
    }

    public function getTotalSum(TotalSumRequest $request)
    {
        return response()->json($this->paymentRepository->getTotalSum(Auth::user(),$request->validated()));
    }

    public function getPaymentsByType(PaymentByTypeRequest $request)
    {
        $data = $request->validated();

        $total = $this->paymentRepository->getTotalByPaymentType(Auth::user(),$data);

        $categories = $this->paymentRepository->getCategoriesData(Auth::user(),$total,$data);

        return response()->json(['total'=>$total, 'categories'=>CategoryResource::collection($categories)], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        if($payment = $this->paymentRepository->create(Auth::user(), $request->validated())){
            return response()->json(['message'=>'Payment was added', 'data'=> new PaymentResource($payment)], 200);
        }
        return response()->json('Error', 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if($this->paymentRepository->delete($payment)){
            return response()->json(['message'=>'Payment was removed', 'data'=> new PaymentResource($payment)], 200);
        }
        return response()->json('Error', 500);
    }
}
