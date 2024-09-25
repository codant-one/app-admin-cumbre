<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

use App\Models\User;
use App\Models\UserRegisterToken;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $query->whereHas('roles', function ($q){
                $q->where('name', 'App');
            });

            $users = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($users, 200);
        }

        return view('admin.cruds.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.cruds.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $password = Str::random(8);
        $request->merge(['password' => $password]);

        $request = $this->prepareRequest($request);

        $user = new User;
        $user->fill($request->all());
        $user->save();
        $user->assignRole('App');

        UserRegisterToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(60)]
        );

        $email = $user->email;
        $subject = 'Bienvenido a la VII Cumbre del Petróleo, Gas y Energía';

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $user->name . ' ' . $user->last_name,
            'email'=> $email,
            'password' => $password
        ];

        try {
            \Mail::send(
                'emails.auth.client_created'
                , ['data' => $data]
                , function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

            $responseMail = 'Correo electrónico enviado al usuario satisfactoriamente.';
        } catch (\Exception $e) {
            $responseMail = 'No se pudo enviar el correo electrónico al usuario';

            Log::info($e);
        } 
        
        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Usuario Creado Exitosamente ('.$responseMail.')'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        if (!$user)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        return view('admin.cruds.clients.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        $user->fill($request->all());
        $user->update();

        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Usuario Actualizado Exitosamente'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if (!$user)
            return redirect()->route('clients.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        $user->delete();

        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Usuario Eliminado'
            ]
        ]);
    }

    public function deleteClients(Request $request)
    {
        try{
            $users = User::whereIn('id', $request->ids)->get();
            
            foreach($users as $user){

                if(auth()->user()->id != $user->id){
                    $delete_user = User::findOrFail($user->id);
                    $delete_user->delete();
                }
            }

            $message = array('message' => 'Usuarios Eliminados Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'danger',
                    'message' => 'Ha ocurrido un error: '.$e
                ]
            ]);
        }
    }

    public function upload(Request $request)
    {
        return view('admin.cruds.clients.upload');
    }

    public function uploadPost(Request $request)
    {
        $password = Str::random(8);
        $request->merge(['password' => $password]);

        $request = $this->prepareRequest($request);

        $user = new User;
        $user->fill($request->all());
        $user->save();
        $user->assignRole('App');

        UserRegisterToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => Str::random(60)]
        );

        $email = $user->email;
        $subject = 'Bienvenido a la VII Cumbre del Petróleo, Gas y Energía';

        $data = [
            'title' => 'Cuenta creada satisfactoriamente!!!',
            'user' => $user->name . ' ' . $user->last_name,
            'email'=> $email,
            'password' => $password
        ];

        try {
            \Mail::send(
                'emails.auth.client_created'
                , ['data' => $data]
                , function ($message) use ($email, $subject) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to($email)->subject($subject);
            });

            $responseMail = 'Correo electrónico enviado al usuario satisfactoriamente.';
        } catch (\Exception $e) {
            $responseMail = 'No se pudo enviar el correo electrónico al usuario';

            Log::info($e);
        } 
        
        return redirect()->route('clients.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Usuario Creado Exitosamente ('.$responseMail.')'
            ]
        ]);
    }

    private function prepareRequest(Request $request)
    {
        $request->password_hash = Hash::make($request->password);
        $request->request->remove('password');
        $request->request->add(['password' => $request->password_hash]);
        $request->request->remove('password_hash');
        
        return $request;
    }
}
