<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class commented extends Notification
{
    use Queueable;

    public $commentor;
    public $post;
    public $post_owner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($commentor, $post, $post_owner)
    {
        $this->commentor = $commentor;
        $this->post = $post;
        $this->post_owner = $post_owner;
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
            "commentor_id" => $this->commentor->id,
            "post_id" => $this->post->id,
            "port_owner_id" => $this->post_owner->id
        ];
    }
}
