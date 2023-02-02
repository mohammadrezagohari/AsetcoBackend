<?php

namespace App\Jobs;

use App\Models\Invite;
use App\Notifications\InvoicePaid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar;
use Str;

class SendSmsInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*****************
     * @var Invite
     */
    protected $invite;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $receptor = $this->invite->invited_mobile_number;
        $yourNumber = $this->invite->User->mobile;
        $inviteName = $this->invite->invited_full_name;
        $fullName = $this->invite->User->name;
        $amount = $this->invite->price;
        $inviteId = $this->invite->id;
        $type = env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = env("KAVEHNEGAR_SMS_PATTERN_INVITE");
        Kavenegar::VerifyLookup($receptor, $yourNumber, $amount, $inviteId, $template, $type, $inviteName, $fullName);
        Log::info($this->invite->created_at,
            [
                'receptor' => $this->invite->invited_mobile_number,
                'yourNumber' => $this->invite->User->mobile,
                'inviteName' => $this->invite->invited_full_name,
                'fullName' => $this->invite->User->name,
                'amount' => $this->invite->price,
                'inviteId' => $this->invite->id
            ]
        );
    }
}
