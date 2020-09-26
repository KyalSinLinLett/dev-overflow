<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class followed_user extends Notification
{
    use Queueable;

    public $follower; //user that followed the account
    public $owner; //user of the account that got followed

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($follower, $owner)
    {
        $this->follower = $follower;
        $this->owner = $owner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'follower_id' => $this->follower->id,
            'owner_id' => $this->owner->id
        ];
    }
}
