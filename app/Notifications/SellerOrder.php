<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SellerOrder extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        if ($this->user['mail'] == 1 && $this->user['notification'] == 1) {
            return ['mail', 'database'];
        }
        
        if ($this->user['mail'] == 1) {
            return ['mail'];
        }

        if ($this->user['notification'] == 1) {
            return ['database'];
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!' .$this->user['name'].',')
            ->line(new HtmlString($this->user['message']))
            ->action('View Order', $this->user['link'])
            ->line('Thank you for using our application!');  
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->user['message'],
            'user_id' => $this->user['user_id'],
            'link' => $this->user['link'],
        ];
    }
}
