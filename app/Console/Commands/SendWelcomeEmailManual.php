<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;

class SendWelcomeEmailManual extends Command
{
    protected $signature = 'send:welcome-email {user_id}';
    protected $description = 'Send a welcome email to a user manually';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $user = User::find($this->argument('user_id'));

        if ($user) {
            SendWelcomeEmail::dispatch($user);
            $this->info('Welcome email sent to ' . $user->email);
        } else {
            $this->error('User not found!');
        }
    }
}