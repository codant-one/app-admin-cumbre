<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;


class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!auth()->user()->can('role_view')) {
        //     abort(403, 'No tienes permiso para esta acción.');
        // }

        if ($request->ajax()) {
            $query = Role::query();

            foreach ($request->input('order') as $order) {
                $query->orderBy($order['column_name'], $order['dir']);
            }

            foreach ($request->input('columns') as $key => $column) {
                if (!$request->filled("columns.$key.search.value")) continue;

                $column_name = $request->input("columns.$key.data");
                $search_value = $request->input("columns.$key.search.value");
                $date_columns = ['created_at'];

                if (in_array($column_name, $date_columns)) {
                    $query->whereDate($column_name, Carbon::parse($search_value)->format('Y-m-d'));
                } else {
                    $query->where($column_name, 'LIKE', "%$search_value%");
                }
            }

            $data = ($request->length == -1) ? $query->paginate( $query->count() ) : $query->paginate($request->length);

            return response()->json($data);
        }

        return view('admin.cruds.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('role_create')) {
        //     abort(403, 'No tienes permiso para esta acción.');
        // }

        $permissions = Permission::select(['id', 'description'])->get();

        return view('admin.cruds.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = $request->input('permissions');

        $request = $this->prepareRequest($request);

        $role = Role::create($request->all());
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol Creado Correctamente'
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
        // if (!auth()->user()->can('role_edit')) {
        //     abort(403, 'No tienes permiso para esta acción.');
        // }

        $rol = Role::findOrFail($id);

        if (!$rol) {
            return redirect()->route('admin.roles.index')->with([
                'feedback' => [
                    'type' => 'toastr',
                    'action' => 'warning',
                    'message' => 'Rol No Encontrado'
                ]
            ]);
        }

        $permissions = Permission::select(['id', 'description'])->get();

        $current_permissions = [];

        foreach ($rol->permissions as $permission) {
            $current_permissions[] = $permission->id;
        }

        return view('admin.cruds.roles.edit', compact('rol', 'current_permissions', 'permissions'));
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
        $rol = Role::findOrFail($id);
       
        $permissions = $request->input('permissions');

        $request = $this->prepareRequest($request);

        $rol->fill($request->all());
        $rol->syncPermissions($permissions);
        $rol->update();

        return redirect()->route('roles.index')->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol Actualizado Correctamente'
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
        // if (!auth()->user()->can('role_delete')) {
        //     abort(403, 'No tienes permiso para esta acción.');
        // }

        $rol = Role::findOrFail($id);
        $rol->delete();

        return redirect()->back()->with([
            'feedback' => [
                'type' => 'toastr',
                'action' => 'success',
                'message' => 'Rol Eliminado Correctamente'
            ]
        ]);
    }

    public function deleteRoles(Request $request)
    {
        try{
            $roles = Role::whereIn('id', $request->ids)->get();
            
            foreach($roles as $role){

                if(auth()->user()->getRoleNames()[0] != $role->name){
                    $delete_role = Role::findOrFail($role->id);
                    $delete_role->delete();
                }
            }

            $message = array('message' => 'Roles Eliminados Exitosamente', 'title' => 'Columnas Eliminadas');
            return response()->json($message);

        } catch(\Exception $e){
            return redirect()->route('roles.index')->with([
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
        $request->request->remove('permissions');
        
        return $request;
    }
}
