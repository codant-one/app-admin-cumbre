<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\SendUserCreatedEmail;

use App\Models\User;
use App\Models\UserCode;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to users with `send` 0';

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
        $userCodes = UserCode::where('send', 0)->get();

        foreach($userCodes as $userCode) {

            $user = User::find($userCode->user_id);

            SendUserCreatedEmail::dispatch($user, $userCode->code)->delay(now()->addSeconds(30));
        }

        $this->info("Emails sent");

        return 0;
    }
}
