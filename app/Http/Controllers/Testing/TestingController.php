<?php

namespace App\Http\Controllers\Testing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App;

use App\Models\User;

class TestingController extends Controller
{

    public function notifications() {
        $url = env('APP_STORE').'/register-confirm?&token='.Str::random(60);
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

    public function forgot_password() {
        $user = User::find(1);
        $lang = $user->lang ?? 'es';

        App::setLocale($lang);
        session()->put('locale', $lang);

        $data = [
            'title' =>  __('emails.change_password_title', [], $lang),
            'text' => __('emails.change_password_text', [], $lang),
            'buttonLink' =>  '' ?? null,
            'buttonText' =>  __('emails.change_password_button', [], $lang) ?? null
        ];

        return view('emails.auth.forgot_pass_confirmation', compact('data'));
    }

    public function reset_password() {
        $user = User::find(1);
        $lang = $user->lang ?? 'es';

        App::setLocale($lang);
        session()->put('locale', $lang);

        $data = [
            'title' =>  __('emails.reset_password_title', [], $lang),
            'text' => __('emails.reset_password_text', [], $lang),
            'buttonLink' =>  '' ?? null,
            'buttonText' =>  __('emails.reset_password_button', [], $lang) ?? null
        ];

        return view('emails.auth.reset_password', compact('data'));
    }

}
