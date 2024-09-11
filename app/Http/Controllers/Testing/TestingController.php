<?php

namespace App\Http\Controllers\Testing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

use App\Models\User;

class TestingController extends Controller
{

    public function notifications() {
        $url = env('APP_DOMAIN').'/register-confirm?&token='.Str::random(60);
        $info = [
            'title' => 'Verificar Correo Electrónico',
            'text' => '<strong>¡Bienvenido a la VII Cumbre del Petróleo, Gas y Energía!</strong> <br>Tu registro ha sido exitoso. <br>Participa con líderes del sector para discutir innovaciones y sostenibilidad en la industria. <br>Si tienes alguna pregunta, no dudes en contactarnos.',
        ];

        $user = User::find(1);
        
        $data = [
            'title' => $info['title'],
            'text' => $info['text'],
            'user' => 'Steffani Castro',
            'buttonLink' =>  $info['buttonLink'] ?? null,
            'buttonText' =>  $info['buttonText'] ?? null
        ];

        return view('emails.auth.notifications', compact('data'));
    }

}
