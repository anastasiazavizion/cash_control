<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Notifications\NewUserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegisteredNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserRegistered $event): void
    {
        $event->user->notify(new NewUserNotification());

    }
}
