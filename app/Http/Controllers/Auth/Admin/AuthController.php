<?php

namespace App\Http\Controllers\Auth\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest; 

use App\Services\GoogleFirebaseConsole;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserRegisterToken;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (empty($user->token_2fa)) {
                $google2fa = app('pragmarx.google2fa');
                $token = $google2fa->generateSecretKey();

                $user->token_2fa = $token;
                $user->update();

                $request->session()->flash('user', $user);

                return redirect()->route('auth.admin.2fa.generate');
            } else {
                return redirect(route('auth.admin.2fa'));
            }
        }

        return redirect()->route('auth.admin.login')->withErrors([
            'email' => 'Las credenciales no coindicen.',
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::check() && session()->get('login') === 'admin')
            return redirect()->route('dashboard.index');

        return view('admin.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();

        return redirect()->route('auth.admin.login');
    }

    public function validate_double_factor_auth(Request $request)
    {
        try {
            $user = auth()->user();
            $google2fa = app('pragmarx.google2fa');
            $token_2fa = explode("-", $request->token_2fa)[0].explode("-", $request->token_2fa)[1];

            if ($google2fa->verifyKey($user->token_2fa, $token_2fa)) {
                session()->put('2fa', '1');
                session()->put('login', 'admin');

                return redirect()->route('dashboard.index');
            }

            return redirect()->route($request->route)->withErrors(['error' => 'Código de verificación incorrecto']);
        } catch (\Exception $e) {
            return redirect()->route($request->route)->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function generate_double_factor_auth()
    {
        $google2fa = app('pragmarx.google2fa');

        $user = auth()->user();
        $token = $user->token_2fa;

        $qr = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $token
        );

        return view('admin.auth.generate-2fa', compact('user', 'qr', 'token'));
    }

    public function double_factor_auth()
    {
        $user = auth()->user();
        $token = $user->token_2fa;

        return view('admin.auth.2fa', compact('user'));
    }

    public function profile(){

        return view('admin.auth.profile');
    }
    
    /**
     * Get the token array structure.
     */
    protected function respondWithToken($token)
    {
        $permissions = getPermissionsByRole(Auth::user());
        $userData = getUserData(Auth::user()->load(['userDetail']));

        $data = [
            'accessToken' => $token,
            'token_type' => 'bearer',
            'user_data' => $userData
        ];

        if (Auth::user()->getRoleNames()[0] === 'App') {//user app
            return $data;
        }  else {
            return array_merge($data, ['userAbilities' => $permissions]);
        }
    
    }
}
