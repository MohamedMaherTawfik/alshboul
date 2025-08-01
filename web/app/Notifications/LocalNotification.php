<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LocalNotification extends Notification
{
    use Queueable;
    private $data;
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
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'target' => $this->data['target'],
            'link' =>    $this->data['link'],
            'target_id' => $this->data['target_id'],
            'user' => $this->data['sender'],
        ];
    }
}
