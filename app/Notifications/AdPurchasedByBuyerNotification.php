<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdPurchasedByBuyerNotification extends Notification
{
    use Queueable;

    private $adId;
    private $adOwnerName;

    /**
     * Create a new notification instance.
     *
     * @param int $adId
     * @param string $adOwnerName
     */
    public function __construct($adId, $adOwnerName)
    {
        $this->adId = $adId;
        $this->adOwnerName = $adOwnerName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ad_id' => $this->adId,
            'message' => "You have purchased '{$this->adOwnerName}' ad.",
        ];
    }
}
