<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ContractEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a command to send email and notification to users whose contract is about to expire.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
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
			$months = $m1 - $m2;
            if(abs($months) == 2){
				$email = $user->email;
				\Log::info("Contract Expired".$user->id);
				Mail::send(
                'emailtemplate.contractend',
                [
                    'email' => $user->email,
                    'user' => $user,

                ],
                function ($message) use ($email) {
                    $message->to('atta779@gmail.com')->subject('Contract Expired.');
                    // $message->to($email)->subject('Contract Expired.');
                });
            }
            exit;
        }
    }
}
