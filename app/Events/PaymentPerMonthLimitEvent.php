<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentPerMonthLimitEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int|float $monthLimit;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user)
    {
        $settings = $this->user->settings;
        $this->monthLimit = $settings->month_limit ?? 0;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('payment_per_month_limit_channel_'.$this->user->id)
        ];
    }

    public function broadcastWith(): array
    {
        return ['limit' => $this->monthLimit];
    }

   public function broadcastWhen(): bool
    {
        $monthTotalSum = $this->user->payments()
            ->where('payment_date', 'LIKE', date('Y-').'%'.date('-m'))
            ->sum('amount');
        return $this->monthLimit > 0 && ($monthTotalSum > $this->monthLimit);
    }
}
