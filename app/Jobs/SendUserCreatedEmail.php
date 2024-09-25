<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\UserCode;

class SendUserCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->user->email;
        $subject = 'Bienvenido a la VII Cumbre del Petróleo, Gas y Energía';

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $this->user->name . ' ' . $this->user->last_name,
            'email' => $email,
            'password' => $this->password
        ];

        try {
            Mail::send('emails.auth.client_created', ['data' => $data], function ($message) use ($email, $subject) {
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $message->to($email)->subject($subject);
            });

            UserCode::where('user_id', $this->user->id)->update(['send' => 1]);
            Log::info($this->user->id . ') Correo enviado.');
        } catch (\Exception $e) {
            Log::error($this->user->id . ') Error: ' . $e->getMessage());
        }
    }
}

