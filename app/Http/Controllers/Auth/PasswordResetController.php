<?php

namespace App\Http\Controllers\Auth;

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
    
    /**
     * @OA\Post(
     *     path="/auth/forgot-password",
     *     summary="Forgot password",
     *     description= "Request password change",
     *     tags={"AUTH"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"email","lang"},
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      format= "email",
     *                      description="The user's E-mail"
     *                  ),
     *                 @OA\Property(
     *                      property="lang",
     *                      type="string",
     *                      format= "text",
     *                      description="App language (es/en)"
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
     *         response=404,
     *         description="Email Not Found"
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
    public function forgot_password(ForgotPasswordRequest $request)
    {
        try {
            $lang = $request->lang ?? 'es';
            $user = User::where('email', $request->email)->first();

            if (!$user)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('auth.email_not_registered', [], $lang)
                ], 404);

            $lang = $user->lang ?? 'es';

            App::setLocale($lang);
            session()->put('locale', $lang);

            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => strtolower($request->email)],
                ['token' => Str::random(60)]
            );

            $email = $user->email;
            $domain = ($user->getRoleNames()[0] === 'App') ? env('APP_STORE') : env('APP_DOMAIN');
            $url = $domain.'/reset_password?token='.$passwordReset['token'].'&email='.$email;
            
            $info = [
                'subject' => __('emails.password_change_request', [], $lang),
                'title' =>  __('emails.change_password_title', [], $lang),
                'text' => __('emails.change_password_text', [], $lang),
                'buttonLink' =>  $url ?? null,
                'buttonText' =>  __('emails.change_password_button', [], $lang) ?? null,
                'email' => 'emails.auth.forgot_pass_confirmation'
            ];     
            
            $responseMail = $this->sendMail($user->id, $info); 

            return response()->json([
                'success' => $responseMail['success'],
                'message' => 'forgot_password',
                'data' => [ 
                    'response_mail' => $responseMail['message']
                ]
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
     * @OA\Get(
     *     path="/auth/password/find",
     *     summary="Find token",
     *     description= "Verify user token",
     *     tags={"AUTH"},
     *     @OA\Parameter(
     *          name="token",
     *          in="query",
     *          description="Token sent via email",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="text",
     *              description="Token"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="lang",
     *          in="query",
     *          description="App language (es/en)",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="text",
     *              description="Lang"
     *          )
     *     ),
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
     *         response=404,
     *         description="Token Not Found"
     *     ),
     *     @OA\Response(
     *         @OA\MediaType(mediaType="application/json"),
     *         response=410,
     *         description="Token expired"
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
    public function find(FindTokenRequest $request)
    {
        try {
            $lang = $request->lang ?? 'es';

            App::setLocale($lang);
            session()->put('locale', $lang);

            $passwordReset = PasswordReset::where('token', $request->token)->first();
            
            if (!$passwordReset)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' => __('emails.token_not_found', [], $lang)
                ], 404);
                
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
                $passwordReset->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'token_expired',
                    'errors' => __('emails.token_expired', [], $lang)
                ], 410);
            }

            return response()->json([
                'success' => true,
                'message' => 'token_success',
                'data' => [
                    'token' => $passwordReset
                ]
                
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
     *     path="/auth/change",
     *     summary="Change password",
     *     description= "Change password",
     *     tags={"AUTH"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"token","email","password","lang"},
     *                  @OA\Property(
     *                      property="token",
     *                      type="string",
     *                      format= "text",
     *                      description="Token sent via email"
     *                  ),
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
     *                      description="The new password"
     *                  ),
     *                 @OA\Property(
     *                      property="lang",
     *                      type="string",
     *                      format= "text",
     *                      description="App language (es/en)"
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
     *         response=404,
     *         description="Email Not Found"
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
    public function change(ChangePasswordRequest $request) {
        try{

            $lang = $request->lang ?? 'es';

            $findTokenRequest = new FindTokenRequest();
            $findTokenRequest->merge([
                'token' => $request->token,
                'lang' => $request->lang,
            ]);

            $requestToken = $this->find($findTokenRequest);

            if ($requestToken->status() != 200)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  json_decode($requestToken->content())->errors
                ], 404);

            $tokenValidated = json_decode($requestToken->content());
            $email = $tokenValidated->data->token->email;
            $user = User::where('email', $request->email)->first();

            if (!$user)
                return response()->json([
                    'success' => false,
                    'message' => 'not_found',
                    'errors' =>  __('auth.email_not_registered', [], $lang)
                ], 404);

            $lang = $user->lang ?? 'es';

            App::setLocale($lang);
            session()->put('locale', $lang);
        
            $user->password = Hash::make($request->password);
            $user->token_2fa = null;
            $user->update();
        
            $url = ($user->getRoleNames()[0] === 'App') ? env('APP_STORE') : env('APP_DOMAIN');
            
            $info = [
                'subject' => __('emails.hi', [], $lang) . $user->name. ' '. $user->last_name . __('emails.reset_password_request', [], $lang),
                'title' =>  __('emails.reset_password_title', [], $lang),
                'text' => __('emails.reset_password_text', [], $lang),
                'buttonLink' =>  $url ?? null,
                'buttonText' =>  __('emails.reset_password_button', [], $lang) ?? null,
                'email' => 'emails.auth.reset_password'
            ];     
            
            $responseMail = $this->sendMail($user->id, $info); 

            return response()->json([
                'success' => $responseMail['success'],
                'message' => 'reset_password',
                'data' => __('emails.password_update', [], $lang)
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
     * Send mail to users
     */
    private function sendMail($id, $info ){

        $user = User::find($id);
        $lang = $user->lang ?? 'es';
        $response = [];

        $data = [
            'title' => $info['title']?? null,
            'user' => $user->name . ' ' . $user->last_name,
            'text' => $info['text'] ?? null,
            'buttonLink' =>  $info['buttonLink'] ?? null,
            'buttonText' =>  $info['buttonText'] ?? null
        ];

        $email = $user->email;
        $subject = $info['subject'];
        
        try {
            \Mail::send($info['email'], $data, function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

            $response['success'] = true;
            $response['message'] =  __('emails.email_success', [], $lang);
        } catch (\Exception $e){
            $response['success'] = false;
            $response['message'] = __('emails.email_error', [], $lang).$e;
        }        

        return $response;

    } 
}
