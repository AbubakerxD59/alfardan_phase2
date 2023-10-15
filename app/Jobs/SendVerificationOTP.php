<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendVerificationOTP implements ShouldQueue
{
    protected $user_email;
    protected $user_otp;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $otp_code)
    {
        $this->user_email = $email;
        $this->user_otp = $otp_code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_email = $this->user_email;
        $user_otp = $this->user_otp;
        Mail::send('emailtemplate.email_verification_code',['otp'=>$user_otp],
        function($message) use ($user_email){
            $message->to($user_email)->subject('Email Verification Code');
        });
    }
}
