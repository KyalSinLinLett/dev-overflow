<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class report_post extends Notification
{
    use Queueable;

    public $sender;
    public $group;
    public $gp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sender, $group, $gp)
    {
        $this->sender = $sender;
        $this->group = $group;
        $this->gp = $gp;    
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
            'sender' => $this->sender->id,
            'group' => $this->group->id,
            'gp' => $this->gp->id
        ];
    }
}
