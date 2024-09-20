<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::with(['roles']);

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if ($column_name == 'roles') { 
                    $query->whereHas('roles', function ($q) use ($search_value) {
                        $q->where('id', $search_value);
                    });
                } elseif($column_name == 'token_2fa'){
                    ($search_value == 'Si') ? $query->whereNotNull('token_2fa') : $query->whereNull('token_2fa');
                } elseif (!in_array($column_name, $date_columns)) {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                } elseif (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                }
            }

            $query->whereHas('roles', function ($q){
                $q->where([['name','!=','App'],['name','!=','Panelista'],['name','!=','SuperAdmin']]);
            });

            $users = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($users, 200);
        }

        $roles_ = Role::where('name','!=','Cliente')->get();
        $roles = Role::select(['name', 'id'])->where('name','!=','Cliente')->pluck('name', 'id');

        return view('admin.cruds.users.index', compact('roles','roles_'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $roles_ = Role::where('name','!=','Cliente')->get();
        $roles = Role::select(['name', 'id'])->where('name','!=','Cliente')->pluck('name', 'id');

        return view('admin.cruds.users.create', compact('roles','roles_'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::find($request->role);

        $request = $this->prepareRequest($request);

        $user = new User;
        $user->fill($request->all());
        $user->save();
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Usuario Creado Exitosamente'
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
        $roles = Role::select('name', 'id')->where('name','!=','Cliente')->get()->toArray();
        
        if (!$user)
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        return view('admin.cruds.users.edit', compact('user', 'roles'));
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
        $role = Role::find($request->role);

        if (!$user)
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        $user->fill($request->all());
        $user->update();
        $user->roles()->detach();
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with([
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
            return redirect()->route('users.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'error',
                    'message' => 'No se encontró el Usuario'
                ]
            ]);

        $user->delete();

        return redirect()->route('users.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'warning',
                'message' => 'Usuario Eliminado'
            ]
        ]);
    }

    public function deleteUsers(Request $request)
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

    private function prepareRequest(Request $request)
    {
        $request->password_hash = Hash::make($request->password);
        $request->request->remove('password');
        $request->request->add(['password' => $request->password_hash]);
        $request->request->remove('password_hash');
        
        return $request;
    }
}
