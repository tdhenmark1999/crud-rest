<?php

namespace App\Laravel\Notifications;

use Helper;
use Illuminate\Bus\Queueable;
use NotificationChannels\FCM\FCMMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FCMNotification extends Notification implements ShouldQueue
{
     use Queueable;

    /**
     * The notification data.
     *
     */
    protected $data;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'fcm' ];
    }

    /**
     * Get the fcm representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\FCM\FCMMessage
     */
    public function toFCM($notifiable)
    {
        $notification = [
            'title' => $this->data->get('title'),
            'body' => $this->data->get('content'),
        ];

        $data = [
            'title' => $this->data->get('title'),
            'body' => $this->data->get('content'),
            'type' => $this->data->get('type'),
            'display_type'  => "", //for future notification with big image when needed
            // 'counter_badge' => 'users.'.$this->id,
            'counter_badge' => 0,
            'reference_id' => $this->data->get('reference_id'),
            'thumbnail' => $this->data->get('thumbnail'),
            'event' => get_class($this),
        ];

        return (new FCMMessage())
            ->notification($notification)
            ->data($data);
    }
}
