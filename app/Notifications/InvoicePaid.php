<?php

namespace App\Notifications;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kavenegar\Laravel\Message\KavenegarMessage;
use Kavenegar\Laravel\Notification\KavenegarBaseNotification;

/*********************
 * @mixin Invite
 */
class InvoicePaid extends KavenegarBaseNotification
{
    use Queueable;

    protected $invite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    public function toKavenegar($notifiable)
    {
        return (new KavenegarMessage())
            ->verifyLookup(env('KAVEHNEGAR_SMS_PATTERN_INVITE'), $this->invite->toArray());
    }
}
