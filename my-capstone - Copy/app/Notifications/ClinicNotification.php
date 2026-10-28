<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClinicNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;

    public function __construct($title, $message, $type = 'info')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
        ];
    }
}
