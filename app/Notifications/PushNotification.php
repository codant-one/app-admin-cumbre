<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;

class PushNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFcm($notifiable)
    {
        $data = [
            'action' => 'open_app', // Acción a realizar
            'device_type' => $this->user->device_type, // Incluye el tipo de dispositivo
        ];

        return FcmMessage::create()
            ->setData($data) // Agrega datos personalizados si es necesario
            ->setNotification([
                'title' => $this->title,
                'body' => $this->body,
            ]);
    }
}
