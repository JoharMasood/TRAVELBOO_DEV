<?php

namespace App\Listeners;

use App\Events\AdPurchased;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AdPurchasedByBuyerNotification;

class AdPurchasedByBuyerListener implements ShouldQueue
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

        if ($adOwner) {
            // Send the notification to the buyer
            $buyer->notify(new AdPurchasedByBuyerNotification($adOwner->id, $adOwner->firstname));

            // Additional logic to update the UI in real-time for the buyer
            // ...
        }
    }
}
