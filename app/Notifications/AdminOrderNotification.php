<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AdminOrderNotification extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->greeting('Hello!')
    //         ->line($this->user['message'])
    //         ->action('Fansfluence', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user['message'],
            'user_id' => $this->user['user_id'],
            'influencer_id' => $this->user['influencer_id'],
        ];
    }
}
