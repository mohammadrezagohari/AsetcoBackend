<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar;

/*****************
 * @var User
 */
class VerificationCodeSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $receptor = $this->user->mobile;
        $yourName = @$this->user->name ? $this->user->name : "آستکو";
        $verification = $this->user->verificationCodes()->create();
        $activationCode = $verification->code;
        $type = env("KAVEHNEGAR_DATA_TYPE_PASS");
        $template = env("KAVEHNEGAR_SMS_PATTERN_ACTIVATION_CODE");
        Kavenegar::VerifyLookup($receptor, $activationCode, null, null, $template, $type, $yourName);
        Log::info($this->user->created_at,
            [
                'User Generate Mobile Number' => $this->user->mobile,
                'Activation Code User' => $verification->code,
            ]
        );
    }
}
