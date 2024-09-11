<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => 'Steffani',
            'last_name' => 'Castro',
            'email' => 'steffani.castro@codant.one',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $superadmin->assignRole('SuperAdmin');

        $admin = User::create([
            'name' => 'Admin',
            'last_name' => '',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $admin->assignRole('Administrador');

        $client = User::create([
            'name' => 'Cliente',
            'last_name' => '',
            'email' => 'client@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $client->assignRole('Cliente');

        $operator = User::create([
            'name' => 'Operador',
            'last_name' => '',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('1234'),
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        $operator->assignRole('Operador');
        
    }
}
