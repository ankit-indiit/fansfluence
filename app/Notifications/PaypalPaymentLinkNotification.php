<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\User;
use Auth;

class PaypalPaymentLinkNotification extends Notification
{
    use Queueable;

    private $user;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {        
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $route = route('order.paypal', $this->order['id']);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line(new HtmlString("<strong>".Auth::user()->name."</strong> has accepted your business <strong>".$this->order['product_name']."</strong> Click the below link to make payment!"))
            ->action('Make payment', $route)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "<strong>".Auth::user()->name."</strong> has accepted your business <strong>".$this->order['product_name']."</strong> Click the below link to make payment!",
            'user_id' => $this->order['user_id'],
            'link' => route('order.paypal', $this->order['id'])
        ];
    }
}
