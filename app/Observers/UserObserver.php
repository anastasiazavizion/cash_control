<?php

namespace App\Observers;

use App\Enum\Role;
use App\Events\NewUserRegistered;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->assignRole(Role::CUSTOMER->value);
        NewUserRegistered::dispatch($user);

    }

}
