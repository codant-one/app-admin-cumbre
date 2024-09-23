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
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserRegisterToken;

class UserController extends Controller
{
   
    /**
     * @OA\Post(
     *   path="/auth/profile/user",
     *   summary="Save profile",
     *   description= "Save info user",
     *   tags={"Users"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"name","last_name","lang"},
     *               @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  format="text",
     *                  description="The user name"
     *               ),
     *               @OA\Property(
     *                  property="last_name",
     *                  type="string",
     *                  format= "text",
     *                  description="The user last name"
     *              ),
     *              @OA\Property(
     *                  property="avatar",
     *                  type="file",
     *                  description="The user avatar"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=500,
     *      description="an ""unexpected"" error"
     *   ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(ProfileRequest $request){

        try {
            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->save();

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');

                $path = 'avatars/';

                $file_data = uploadFile($image, $path, $user->avatar);

                $user->avatar = $file_data['filePath'];
                $user->save();
            }

            return response()->json([
                'success' => true,
                'data' => getUserData(Auth::guard('api')->user()->load(['userDetail']))
            ], 200);

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
     * @OA\Post(
     *   path="/auth/profile/user/updatePassword",
     *   summary="Update password",
     *   description= "Update user password",
     *   tags={"Users"},
     *   security={{"bearerAuth": {} }},
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              required={"password","lang"},
     *              @OA\Property(
     *                  property="password",
     *                  type="string",
     *                  format= "text",
     *                  description="The password"
     *              ),
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  format= "text",
     *                  description="App language (es/en)"
     *              )
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=200,
     *      description="successful operation",
     *    ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=400,
     *      description="Some was wrong"
     *   ),
     *   @OA\Response(
     *      @OA\MediaType(mediaType="application/json"),
     *      response=500,
     *      description="an ""unexpected"" error"
     *   ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(PasswordRequest $request){

        try {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->password);
            $user->update();

            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);

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
