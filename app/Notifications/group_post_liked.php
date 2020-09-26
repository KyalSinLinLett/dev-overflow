<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class group_post_liked extends Notification
{
    use Queueable;

    public $post_owner;
    public $liker;
    public $post;
    public $group;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($po, $liker, $post, $group)
    {
        $this->post_owner = $po;
        $this->liker = $liker;
        $this->post = $post;
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
    public function toDatabase($notifiable)
    {
        return [
            'post_owner_id' => $this->post_owner->id,
            'liker_id' => $this->liker->id,
            'post_id' => $this->post->id,
            'group_id' => $this->group->id
        ];
    }
}
