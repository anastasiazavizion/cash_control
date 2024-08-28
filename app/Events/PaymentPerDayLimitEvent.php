<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentPerDayLimitEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int|float $dayLimit;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user)
    {
        $settings = $this->user->settings;
        $this->dayLimit = $settings->day_limit ?? 0;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('payment_per_day_limit_channel_'.$this->user->id)
        ];
    }

    public function broadcastWith(): array
    {
        return ['limit' => $this->dayLimit];
    }

   public function broadcastWhen(): bool
    {
        $todayTotalSum = $this->user->payments()->where('payment_date', date('Y-m-d'))->sum('amount');
        return $this->dayLimit > 0 && ($todayTotalSum > $this->dayLimit);
    }
}
