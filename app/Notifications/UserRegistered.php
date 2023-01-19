<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserRegistered extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello '.$this->user['name'].'!')
            ->line(new HtmlString('You have successfully registered as an Influencer.'))
            ->line('Please wait for admin approval.')
            ->action('Fansfluence!', route('home'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => '<strong>'.$this->user['name'].'</strong>! You have successfully registered as an Influencer!',
            'user_id' => $this->user['id'],            
        ];
    }
}
