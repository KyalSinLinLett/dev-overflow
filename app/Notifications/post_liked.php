<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class post_liked extends Notification
{
    use Queueable;

    public $post_owner;
    public $liker;
    public $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($po, $liker, $post)
    {
        $this->post_owner = $po;
        $this->liker = $liker;
        $this->post = $post;
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
            'post_owner_id' => $this->post_owner->id,
            'liker_id' => $this->liker->id,
            'post_id' => $this->post->id 
        ];
    }
}
