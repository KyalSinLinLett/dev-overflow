<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class shared_post extends Notification
{
    use Queueable;

    public $post;
    public $post_owner;
    public $sharer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post, $post_owner, $sharer)
    {
        $this->post = $post;
        $this->post_owner = $post_owner;
        $this->sharer = $sharer;
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
            'post_id' => $this->post->id,
            'post_owner_id' => $this->post_owner->id,
            'sharer_id' => $this->sharer->id
        ];
    }
}
