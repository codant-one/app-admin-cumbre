<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Services\ExpoHost;

class SendUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $token;
    public $title;
    public $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token, $title, $body)
    {
        $this->token = $token;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->expoHost = new ExpoHost();
        $this->expoHost->pushNotification([$this->token], $this->title, $this->body);
    }
}

