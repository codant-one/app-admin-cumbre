<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asigne all permissions to ROL SuperAdmin
        $admin = Role::where('name', 'SuperAdmin')->first();

        Permission::create([
            'name' => 'administrador'
        ])->assignRole($admin);
        
        $data = [ 
            ['name' => 'ver dashboard'],
            ['name' => 'ver usuarios'],
            ['name' => 'crear usuarios'],
            ['name' => 'editar usuarios'],
            ['name' => 'eliminar usuarios'],
            ['name' => 'ver roles'],
            ['name' => 'crear roles'],
            ['name' => 'editar roles'],
            ['name' => 'eliminar roles'],
        ]; 

        $permissions = [];

        foreach($data as $permission){
            $permission['guard_name'] = 'api';
            $permission['created_at'] = Carbon::now();
            $permission['updated_at'] = Carbon::now();
            $permissions[] = $permission;
        }

        $data = Permission::insert($permissions);
    }
}
