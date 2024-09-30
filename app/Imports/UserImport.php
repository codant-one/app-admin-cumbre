<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Jobs\SendUserCreatedEmail;

use App\Models\User;
use App\Models\UserRegisterToken;
use App\Models\UserCode;

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
        $user->email = strtolower($row[2]);
        $user->password = Hash::make($password);
        $user->save();
        $user->assignRole('App');

        UserRegisterToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(60)]
        );

        $userCode = new UserCode;
        $userCode->user_id = $user->id;
        $userCode->code = $password;
        $userCode->save();

        // Enviar el correo en segundo plano usando colas
        SendUserCreatedEmail::dispatch($user, $password)->delay(now()->addSeconds(30));

        return $user;
    }
}
