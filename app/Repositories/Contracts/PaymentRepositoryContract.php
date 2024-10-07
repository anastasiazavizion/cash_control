<?php

namespace App\Repositories\Contracts;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface PaymentRepositoryContract
{
    public function create(User|Authenticatable $user, array $data): Payment;
    public function delete(Payment $payment): bool;
    public function getTotalSum(User|Authenticatable $user, array $filters): float;

    public function getTotalByPaymentType(User|Authenticatable $user,array $filters): float;

    public function getCategoriesData(User|Authenticatable $user,float $total,array $filters);

}
