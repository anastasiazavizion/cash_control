<?php

namespace App\Repositories\Contracts;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface PaymentRepositoryContract
{
    public function create(User|Authenticatable $user, array $data): Payment;
    public function delete(Payment $payment): bool;
    public function getTotalSum(array $filters): float;

    public function getTotalByPaymentType(array $filters): float;

    public function getCategoriesData(float $total,array $filters);

}
