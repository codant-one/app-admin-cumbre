<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LandingController extends Controller
{
    public function index()
    {
        return view('landings.index');
    }

    public function policy()
    {
        return view('landings.politics');
    }

    public function terms()
    {
        return view('landings.terms');
    }

    public function delete_account()
    {
        return view('landings.delete_account');
    }

    public function delete_data(Request $request)
    {
              
                $validated = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ]);
                $user = User::where('email', $validated['email'])->first();

                if ($user && Hash::check($validated['password'], $user->password)) {
                    
                    Mail::send([], [], function($message) use ($user) {
                        $message->to('app.cumbredelpetroleo@gmail.com')
                                ->subject('Solicitud eliminación de datos')
                                ->setBody(
                                    "{$user->email}. Credenciales validades correctamente",
                                    'text/html'
                                );
                    });
                    return redirect()->back()->with('success', 'Solicitud enviada con éxito');
                } else {

                    return redirect()->back()->with('error', 'Las credenciales no son válidas');
                }
    }
}
