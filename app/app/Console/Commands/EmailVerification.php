<?php

namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;

class EmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:email-verify {email}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
    
        $user = User::where('email', $email)->first();
        $this->info($email);
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
    
            $this->info("The email verified at column for the user with email {$email} has been updated.");
        } else {
            $this->error("No user was found with the email address {$email}.");
        }
    }
    
}
