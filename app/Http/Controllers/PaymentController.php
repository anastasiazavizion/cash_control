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
        return response()->json($this->paymentRepository->getTotalSum($request->validated()));
    }

    public function getPaymentsByType(PaymentByTypeRequest $request)
    {
        $data = $request->validated();

        $total = $this->paymentRepository->getTotalByPaymentType($data);

        $categories = $this->paymentRepository->getCategoriesData($total,$data);

        return response()->json(['total'=>$total, 'categories'=>CategoryResource::collection($categories)], 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
