<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest; 

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserRegisterToken;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => 
            ['login', 'register']
        ]);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="User login",
     *     description= "Give a user access to the page",
     *     tags={"AUTH"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"email","password"},
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      format= "email",
     *                      description="The user's E-mail"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      format= "password",
     *                      description="User alphanumeric password"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=400,
     *         description="Some was wrong"
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=500,
     *         description="an ""unexpected"" error"
     *     ),
     *  )
     * 
     * Store a newly created resource in storage
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = request(['email', 'password']);

            $expired = now()->addHours(24);
                
            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'invalid_credentials',
                    'errors' => 'Usuario o contraseña invalida'
                ], 400);
            }

            if (empty(Auth::user()->email_verified_at) && (Auth::user()->getRoleNames()[0] === 'Cliente')) {
                Auth::logout();

                return response()->json([
                    'success' => false,
                    'message' => 'not_confirm',
                    'errors' => 'Correo electrónico no verificado. Revise su correo electrónico donde se le indica los pasos a seguir para verificar el mismo.'
                ], 400);
            }

            $user = Auth::user();
            $user->online = Carbon::now();
            $user->save();

            if (env('APP_DEBUG') || ($user->is_2fa === 0)) {
                return response()->json([
                    'success' => true,
                    'message' => 'login_success',
                    'data' => $this->respondWithToken($token)
                ], 200);
            }

            if (empty($user->token_2fa)) {
                $google2fa = app('pragmarx.google2fa');
                $token2FA = $google2fa->generateSecretKey();

                $user->token_2fa = $token2FA;
                $user->update();

                $qr = $google2fa->getQRCodeUrl(
                    config('app.name'),
                    $user->email,
                    $token2FA
                );

                $data = [
                    'qr' => $qr,
                    'token' => $token2FA
                ];

                return response()->json([
                    'success' => true,
                    'message' => '2fa-generate',
                    'data' => array_merge($data, $this->respondWithToken($token))
                ], 200);

            } else {

                $data = [
                    'token' => $user->token_2fa
                ];

                return response()->json([
                    'success' => true,
                    'message' => '2fa',
                    'data' => array_merge($data, $this->respondWithToken($token))
                ], 200);
            }
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

            $user->assignRole('Cliente');
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
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Logout",
     *     description= "Logout User",
     *     tags={"AUTH"},
     *     security={{"bearerAuth": {} }},
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=500,
     *         description="an ""unexpected"" error"
     *     ),
     *  )
     *
     * Log the user out (Invalidate the token).
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::logout();

            return response()->json([
                'success' => true,
                'message' => 'log_out_successfully'
            ], 200);

        } catch(\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => 'server_error',
                'exception' => $ex->getMessage()
            ], 500);
        }
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken($token)
    {
        $permissions = getPermissionsByRole(Auth::user());
        $userData = getUserData(Auth::user()->load(['userDetail']));

        return [
            'accessToken' => $token,
            'token_type' => 'bearer',
            'user_data' => $userData,
            'userAbilities' => $permissions
        ];
    }

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
