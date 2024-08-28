<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('payment_per_day_limit_channel_{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('payment_per_month_limit_channel_{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
