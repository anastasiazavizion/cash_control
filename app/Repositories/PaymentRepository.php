<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryContract;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class PaymentRepository implements PaymentRepositoryContract
{

    public function create(User|Authenticatable $user, array $data) : Payment
    {
        return $user->payments()->save(Payment::make($data));
    }

    public function delete(Payment $payment): bool
    {
        return $payment->delete();
    }

    public function getTotalSum() :float
    {
        $totalSum = Payment::selectRaw('SUM(CASE WHEN payment_type_id = 1 THEN amount ELSE 0 END) as positive_sum')
            ->selectRaw('SUM(CASE WHEN payment_type_id = 2 THEN amount * -1 ELSE 0 END) as negative_sum')
            ->first();
        return $totalSum->positive_sum + $totalSum->negative_sum;
    }

    public function getTotalByPaymentType(int $typeId): float
    {
        return Payment::byPaymentType($typeId)->sum('amount');
    }

    public function getCategoriesData(float $total,int  $typeId)
    {
        return Category::with(['icon', 'payments' => function($q) use ($typeId) {
            $q->byPaymentType($typeId);
        }])
            ->withSum(['payments as total_amount' => function ($q) use ($typeId) {
                $q->byPaymentType($typeId);
            }], 'amount')
            ->whereHas('payments', function ($q) use ($typeId) {
                $q->byPaymentType($typeId);
            })
            ->get()
            ->each(function ($category) use ($total) {
                $category->percent = round($category->total_amount * 100 / $total, 2);
            });

    }
}
