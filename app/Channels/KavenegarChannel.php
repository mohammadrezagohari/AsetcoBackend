<?php

namespace App\Channels;


use Illuminate\Notifications\Notification;

class KavenegarChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toKavenegar($notifiable);

        // Send notification to the $notifiable instance...
    }
}
