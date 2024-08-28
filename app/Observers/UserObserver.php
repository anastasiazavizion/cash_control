<?php

namespace App\Observers;

use App\Events\NewUserRegistered;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        NewUserRegistered::dispatch($user);

    }

}
