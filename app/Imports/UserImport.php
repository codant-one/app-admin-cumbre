<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\UserRegisterToken;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $password = Str::random(8);

        $user = new User;
        $user->name = $row[0];
        $user->last_name = $row[1];
        $user->email = $row[2];
        $user->password = Hash::make($password);
        $user->save();
        $user->assignRole('App');

        UserRegisterToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(60)]
        );

        $email = $user->email;
        $subject = 'Bienvenido a la VII Cumbre del Petróleo, Gas y Energía';

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $user->name . ' ' . $user->last_name,
            'email'=> $email,
            'password' => $password
        ];

        try {
            \Mail::send(
                'emails.auth.client_created'
                , ['data' => $data]
                , function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

        } catch (\Exception $e) {
            Log::info($e);
        } 

        return $user;
    }
}
