<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdPurchasedByOwnerNotification extends Notification
{
    use Queueable;

    private $adId;
    private $buyerName;

    /**
     * Create a new notification instance.
     *
     * @param int $adId
     * @param string $buyerName
     */
    public function __construct($adId, $buyerName)
    {
        $this->adId = $adId;
        $this->buyerName = $buyerName;
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
            'message' => "Your ad has been purchased by '{$this->buyerName}'.",
        ];
    }
}
