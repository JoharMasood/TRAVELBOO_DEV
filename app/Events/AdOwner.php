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
use Illuminate\Notifications\Notifiable;

class AdOwner implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Notifiable;

    public $id;
    public $firstname;

    /**
     * Create a new AdOwner instance.
     *
     * @param  int  $id
     * @param  string  $firstname
     */
    public function __construct($id, $firstname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
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
            'ad_owner_id' => $this->getId(),
            'ad_owner_name' => $this->getFirstname(),
        ];
    }

    /**
     * Get the ID of the ad owner.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the firstname of the ad owner.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
}
