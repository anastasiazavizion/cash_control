<?php

namespace App\Observers;

use App\Events\PaymentPerDayLimitEvent;
use App\Events\PaymentPerMonthLimitEvent;
use App\Models\Payment;
use App\Models\User;

class PaymentObserver
{
    private function callPaymentLimitEvents(User $user): void
    {
        PaymentPerDayLimitEvent::dispatch($user);
        PaymentPerMonthLimitEvent::dispatch($user);
    }

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        $this->callPaymentLimitEvents($payment->user);

    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        $this->callPaymentLimitEvents($payment->user);
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }
}
