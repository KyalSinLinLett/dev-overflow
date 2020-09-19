<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class priv_group_invite_accepted extends Notification
{
    use Queueable;

    public $sender;
    public $recipient;
    public $group;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $recipient, $group)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->group = $group;
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
    public function toArray($notifiable)
    {
        return [
            "sender" => $this->sender,
            "recipient" => $this->recipient,
            "group" => $this->group
        ];
    }
}
