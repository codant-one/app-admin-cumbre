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
            $info = [
                'text' => 'Credenciales evaluadas con exito',
                'subject' => 'Solicitud de eliminación de datos',
                'email' => 'emails.landing_email'
            ];    
            $responseMail = $this->sendMail($info, $user->id); 
            return redirect()->back()->with('success', 'Solicitud enviada con éxito');
        } else {
            return redirect()->back()->with('error', 'Las credenciales no son válidas');
        }
    }


    
    /**
     * Send mail to users
     */
    private function sendMail($info, $id)
    {

        $user = User::find($id);
        
        $data = [
            'name' => $info['name'] ?? null,
            'title' => $info['title'] ?? null,
            'user' => $user->name . ' ' . $user->last_name,
            'text' => $info['text'] ?? null,
        ];

        $email = ($id === 1) ? env('MAIL_TO_CONTACT') : $user->email;
        $subject = $info['subject'];
        
        try {
            \Mail::send($info['email'], $data, function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to('app.cumbredelpetroleo@gmail.com')->subject($subject);
            });

            return "Tu solicitud se ha procesado satisfactoriamente.";
        } catch (\Exception $e){
            return "Error al enviar el correo electrónico. ".$e;
        }

    } 
}
