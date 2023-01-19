<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use App\Models\User;
use Auth;

class DeclineBuyerOrderNotification extends Notification
{
    use Queueable;

    private $user;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        $user = User::findOrFail($this->order['user_id']);
        $mail = $user->alert('order_update', 'email');       
        $notification = $user->alert('order_update', 'notification'); 
        if ($mail == 1 && $notification == 1) {
            return ['mail', 'database'];
        }
        
        if ($mail == 1) {
            return ['mail'];
        }

        if ($notification == 1) {
            return ['database'];
        } 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!')
            ->line(new HtmlString("<strong>".Auth::user()->name."</strong> has decline your business <strong>".$this->order['product_name']."</strong>"))
            // ->action('View order', route('order.detail', [$this->order['id'], 'influencer']))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "<strong>".Auth::user()->name."</strong> has decline your business <strong>".$this->order['product_name']."</strong>",
            'user_id' => $this->order['user_id'],
            // 'link' => route('order.detail', [$this->order['id'], 'influencer'])
        ];
    }
}
