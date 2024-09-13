<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest; 

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserRegisterToken;

class UserController extends Controller
{
   
    public function register(RegisterRequest $request): JsonResponse
    {

        try {

            $password = $request->input('password');
            $hashedPassword = Hash::make($password);

            $user = new User();
            $user->name = $request->name;
            $user->email = strtolower($request->email);
            $user->password = $hashedPassword;
            $user->save();

            //Crear o Actualizar token.
            $registerConfirm = UserRegisterToken::updateOrCreate(
                ['user_id' => $user->id],
                ['token' => Str::random(60)]
            );

            $userDetails = new UserDetails();
            $userDetails->user_id = $user->id;
            $userDetails->save();

            $user->assignRole('App');
            $email = $user->email;
                
            $info = [
                'text' => '<strong>¡Bienvenido a la VII Cumbre del Petróleo, Gas y Energía!</strong> <br>Tu registro ha sido exitoso. <br>Participa con líderes del sector para discutir innovaciones y sostenibilidad en la industria. <br>Si tienes alguna pregunta, no dudes en contactarnos.',
                'subject' => 'Bienvenido a la VII Cumbre del Petróleo, Gas y Energía',
                'email' => 'emails.auth.notifications'
            ];
                
            $responseMail = $this->sendMail($info, $user->id); 

            return response()->json([
                'success' => true,
                'message' => 'registration_successful',
                'data' => [ 
                    'response_mail' => $responseMail,
                    'user' => User::with(['userDetail'])->find($user->id)
                ]
            ]);

        } catch(\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'database_error',
                'exception' => $ex->getMessage()
            ], 500);
        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }

    }


    /**
     * Send mail to users
     */
    private function sendMail($info, $id = 1)
    {

        $user = User::find($id);
        
        $data = [
            'name' => $info['name'] ?? null,
            'title' => $info['title'] ?? null,
            'user' => $user->name . ' ' . $user->last_name,
            'text' => $info['text'] ?? null,
            'buttonLink' =>  $info['buttonLink'] ?? null,
            'buttonText' =>  $info['buttonText'] ?? null
        ];

        $email = ($id === 1) ? env('MAIL_TO_CONTACT') : $user->email;
        $subject = $info['subject'];
        
        try {
            \Mail::send($info['email'], $data, function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

            return "Tu solicitud se ha procesado satisfactoriamente. Correo electrónico verificado. Le invitamos a que inicie sesion.";
        } catch (\Exception $e){
            return "Error al enviar el correo electrónico. ".$e;
        }

    } 
}
