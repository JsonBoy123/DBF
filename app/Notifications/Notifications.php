<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class Notifications extends Notification
{
    use Queueable;
    use Notifiable;

    public $data;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'id'        =>  $this->data['id'],
            'user'      =>  $this->data['user'],
            'url'       =>  $this->data['url'],
            'message'   =>  $this->data['message']
        ];
    }
}
