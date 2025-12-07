<?php

namespace App\Events;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdPurchased implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $adOwner;
    public $buyer;
    public $ad;

    /**
     * Create a new event instance.
     *
     * @param User $adOwner
     * @param User $buyer
     * @param Ad $ad
     */
    public function __construct(User $adOwner, User $buyer, Ad $ad)
    {
        $this->adOwner = $adOwner;
        $this->buyer = $buyer;
        $this->ad = $ad;
    }



    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('ad-purchased-channel');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'ad_owner_id' => $this->adOwner->id,
            'ad_owner_name' => $this->adOwner->firstname,
            'buyer_name' => $this->buyer->firstname,
        ];
    }
}
