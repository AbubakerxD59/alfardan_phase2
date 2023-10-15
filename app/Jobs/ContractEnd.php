<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ContractEnd implements ShouldQueue
{
    // protected $email;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct($user)
    public function __construct()
    {
        // $this->email = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::get();
		$now = strtotime(date('Y-m-d'));
        foreach($users as $user){
            $email = $user->emai;
			$endDate = strtotime($user->end_date);
			$diff = $endDate - $now; 
			$diffInSeconds = (int)round($diff/(60*60*24));
			if($diffInSeconds <= 0){
				$user->status = 0;
				$user->save();
			}
            $m1 = date('m', $now);
			$m2 = date('m', $endDate);
			$months = $m2 - $m1;
            \Log::info("Cron is working fine!");
            if($months == 2){
                Mail::send('emailtemplate.contractend',['user'=>$user],
				   function($message) use ($email){
					   $message->to('attaullah@hiconsolutions.com')->subject('Contract Expired'); 
					   $message->cc($email);
                });
            }
        }
    }
}
