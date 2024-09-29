<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App;

use App\Http\Requests\ForgotPasswordRequest; 
use App\Http\Requests\FindTokenRequest;
use App\Http\Requests\ChangePasswordRequest;

use Carbon\Carbon;

use App\Models\PasswordReset;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function forgot_password()
    {
       return view('admin.auth.forgot-password');
    }

    public function app_forgot_password()
    {
       return view('admin.auth.app-forgot-password');
    }

    public function email_confirmation(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user)
            return redirect()->route($request->route)->withErrors('Correo electronico no registrado');

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => Str::random(60)]
        );
        
        $url = env('APP_URL').'/admin/reset-password?token='.$passwordReset['token'];
        
        $data = [
            'title' => 'Hemos recibido una solicitud para renovar Contraseña',
            'user' => $user->name . ' ' . $user->last_name,
            'text' => 'VII cumbre te informa, que hemos recibido tu solicitud para renovar tu Contraseña.
            <br><br>
            Por favor confirma dicha solicitud haciendo clic en el enlace a continuación: ',
            'buttonLink' =>  $url ?? null,
            'buttonText' => 'Confirmar Renovación de Contraseña' 
        ];

        $adminEmail = $user->email;
        
        $subject = 'Solicitud de Renovación de Contraseña';
        
        try {
            \Mail::send(
                'emails.auth.forgot_pass_confirmation'
                , $data
                , function ($message) use ($adminEmail, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($adminEmail)->subject($subject);
            });

            $responseMail = 'Te hemos enviado un email con los detalles para el restablecimiento de tu contraseña';
        } catch (\Exception $e){
            $responseMail = 'Error al intentar enviar el email';//.$e->getMessage();
        }        

        return redirect()->route("auth.admin.login")->with( ["register_success" => $responseMail] );

    }

    public function app_email_confirmation(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user)
            return redirect()->route($request->route)->withErrors('Correo electronico no registrado');

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => Str::random(60)]
        );
        
        $url = env('APP_URL').'/reset-password?token='.$passwordReset['token'];
        
        $data = [
            'title' => 'Hemos recibido una solicitud para renovar Contraseña',
            'user' => $user->name . ' ' . $user->last_name,
            'text' => 'VII cumbre te informa, que hemos recibido tu solicitud para renovar tu Contraseña.
            <br><br>
            Por favor confirma dicha solicitud haciendo clic en el enlace a continuación: ',
            'buttonLink' =>  $url ?? null,
            'buttonText' => 'Confirmar Renovación de Contraseña' 
        ];

        $adminEmail = $user->email;
        
        $subject = 'Solicitud de Renovación de Contraseña';
        
        try {
            \Mail::send(
                'emails.auth.forgot_pass_confirmation'
                , $data
                , function ($message) use ($adminEmail, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($adminEmail)->subject($subject);
            });

            $responseMail = 'Te hemos enviado un email con los detalles para el restablecimiento de tu contraseña';
        } catch (\Exception $e){
            $responseMail = 'Error al intentar enviar el email';//.$e->getMessage();
        }        

        return redirect()->route("auth.app.forgot.password")->with( ["register_success" => $responseMail] );

    }

    public function reset_password(Request $request)
    {
        $token = $request->token;

        return view('admin.auth.reset-password', compact('token') );
        
    }

    public function app_reset_password(Request $request)
    {
        $token = $request->token;

        return view('admin.auth.app-reset-password', compact('token') );
        
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
         ->first();
        if (!$passwordReset)
            return response()->json([
                "ERROR" => true,'ERROR_MENSAGGE' => 'Token inválido',"CODE" =>404], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                "ERROR" => true,'ERROR_MENSAGGE' => 'Token inválido' ,"CODE" =>404], 404);
        }

        $response["message_return"] = array("ERROR" => false,"ERROR_MENSAGGE" => 'exitoso',"CODE" =>200);
        $response["result"] = $passwordReset;

        return response()->json($response, 200);
    }

    public function app_find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
         ->first();
        if (!$passwordReset)
            return response()->json([
                "ERROR" => true,'ERROR_MENSAGGE' => 'Token inválido',"CODE" =>404], 404);

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                "ERROR" => true,'ERROR_MENSAGGE' => 'Token inválido' ,"CODE" =>404], 404);
        }

        $response["message_return"] = array("ERROR" => false,"ERROR_MENSAGGE" => 'exitoso',"CODE" =>200);
        $response["result"] = $passwordReset;

        return response()->json($response, 200);
    }

    public function change(Request $request)
    {

        if ($this->find($request->token)->status() != 200)
            return redirect()->back()->withErrors('El token es inválido!');

        $tokenValidated = json_decode($this->find($request->token)->content());
        $email = $tokenValidated->result->email;

        $user = User::where('email', $email)->first();

        if (!$user)
            return redirect()->back()->withErrors('Correo electronico no registrado');

        $user->password = Hash::make($request->password);
        $user->token_2fa = null;
        $user->update();

        $response = 'La Contraseña ha sido actualizada';
        
        return redirect()->route("auth.admin.login")->with(["register_success" => $response]);

    }

    public function app_change(Request $request)
    {

        if ($this->find($request->token)->status() != 200)
            return redirect()->back()->withErrors('El token es inválido!');

        $tokenValidated = json_decode($this->find($request->token)->content());
        $email = $tokenValidated->result->email;

        $user = User::where('email', $email)->first();

        if (!$user)
            return redirect()->back()->withErrors('Correo electronico no registrado');

        $user->password = Hash::make($request->password);
        $user->token_2fa = null;
        $user->update();

        $response = 'La Contraseña ha sido actualizada';
        
        return redirect()->route("auth.app.forgot.password")->with(["register_success" => $response]);

    }

}
