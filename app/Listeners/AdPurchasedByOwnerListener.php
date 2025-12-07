<?php

namespace App\Listeners;

use App\Events\AdPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AdPurchasedByOwnerNotification;

class AdPurchasedByOwnerListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\AdPurchased  $event
     * @return void
     */
    public function handle(AdPurchased $event)
    {
        $adOwner = $event->adOwner;
        $buyer = $event->buyer;

        // Send the notification to the ad owner
        $adOwner->notify(new AdPurchasedByOwnerNotification($buyer->id, $buyer->firstname));

        // Additional logic to update the UI in real-time for the ad owner
        // ...
    }
}
