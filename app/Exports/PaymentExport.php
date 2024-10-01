<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentExport implements FromCollection, WithHeadings
{

    public function __construct(public User|Authenticatable $user)
    {

    }

    public function headings(): array {
        return [
            "Amount",
            "Payment_date",
            "Category"
        ];
    }

    /**
    * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function collection()
    {
        return $this->user->payments()->with('category')->latest()->get()->map(function ($payment){
            return [
                'amount'=>$payment->amount,
                'payment_date'=>$payment->payment_date,
                'category'=>$payment->category->name,
            ];
        });
    }
}
